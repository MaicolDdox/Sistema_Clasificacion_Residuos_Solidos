<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Http\Requests\StoreHazardouWasteRequest;
use Modules\Wastes\Http\Requests\UpdateHazardouWasteRequest;
use Modules\Wastes\Models\HazardouWaste;
use Modules\Wastes\Services\EvidenceImageService;

class HazardouWasteController extends Controller
{
    public function __construct(
        private readonly EvidenceImageService $evidenceImageService
    ) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductiveUnit $unit)
    {
        return view('wastes::respel-create', compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHazardouWasteRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('evidence_image')) {
            $validated['evidence_image'] = $this->evidenceImageService->store(
                $request->file('evidence_image'),
                'evidences/hazardou_wastes'
            );
        } else {
            unset($validated['evidence_image']);
        }

        $validated['user_id'] = Auth::id();

        $waste = HazardouWaste::create($validated);

        return redirect()
            ->route('hazardou-wastes.byUnit', ['unit' => $waste->productive_unit_id])
            ->with('success', 'Residuo peligroso registrado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HazardouWaste $hazardouWaste)
    {
        // Aprendiz solo puede editar sus propios registros
        // Cambio realizado por John
        if (Auth::user()->hasRole('Aprendiz') && $hazardouWaste->user_id !== Auth::id()) {
            abort(403, 'No puedes editar registros de otros usuarios.');
        }

        $unit = $hazardouWaste->productiveUnit;

        return view('wastes::respel-edit', compact('hazardouWaste', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHazardouWasteRequest $request, HazardouWaste $hazardouWaste)
    {
        // Aprendiz solo puede actualizar sus propios registros
        if (Auth::user()->hasRole('Aprendiz') && $hazardouWaste->user_id !== Auth::id()) {
            abort(403, 'No puedes editar registros de otros usuarios, solo lider ambiental.');
        }

        $validated = $request->validated();

        if ($request->hasFile('evidence_image')) {
            $validated['evidence_image'] = $this->evidenceImageService->replace(
                $request->file('evidence_image'),
                'evidences/hazardou_wastes',
                $hazardouWaste->evidence_image
            );
        } else {
            unset($validated['evidence_image']);
        }

        $hazardouWaste->update($validated);

        return redirect()
            ->route('hazardou-wastes.byUnit', ['unit' => $hazardouWaste->productive_unit_id])
            ->with('success', 'Residuo peligroso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HazardouWaste $hazardouWaste)
    {
        $this->evidenceImageService->delete($hazardouWaste->evidence_image);

        $unitId = $hazardouWaste->productive_unit_id;
        $hazardouWaste->delete();

        return redirect()
            ->route('hazardou-wastes.byUnit', ['unit' => $unitId])
            ->with('success', 'Residuo peligroso eliminado correctamente.');
    }

    /**
     * List hazardous wastes by productive unit with DataTable-friendly payload.
     */
    public function byUnit(Request $request, ProductiveUnit $unit)
    {
        if ($request->ajax()) {
            $wastes = HazardouWaste::with('user')
                ->where('productive_unit_id', $unit->id)
                ->orderByDesc('entry_date')
                ->get()
                ->map(function ($waste) {
                    return [
                        'entry_date' => optional($waste->entry_date)->format('Y-m-d H:i'),
                        'waste_type' => $waste->waste_type,
                        'amount' => $waste->amount,
                        'observations' => Str::limit($waste->observations, 120),
                        'usuario' => $waste->user?->name ?? 'N/D',
                        'grupo_semana' => $this->weekLabel($waste->entry_date),
                        'acciones' => view('wastes::partials.respel-actions', compact('waste'))->render(),
                    ];
                });

            return response()->json(['data' => $wastes]);
        }

        return view('wastes::respel-index', compact('unit'));
    }

    private function weekLabel($date): string
    {
        $carbonDate = Carbon::parse($date);
        $start = $carbonDate->copy()->startOfWeek(Carbon::MONDAY);
        $end = $start->copy()->addDays(6);

        return 'Semana del '.$start->format('d/m/Y').' al '.$end->format('d/m/Y');
    }
}
