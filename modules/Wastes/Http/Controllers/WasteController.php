<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Http\Requests\StoreWasteRequest;
use Modules\Wastes\Http\Requests\UpdateWasteRequest;
use Modules\Wastes\Models\Waste;
use Modules\Wastes\Services\EvidenceImageService;

class WasteController extends Controller
{
    public function __construct(
        private readonly EvidenceImageService $evidenceImageService
    ) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductiveUnit $unit)
    {
        return view('wastes::resol-create', compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWasteRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('evidence_image')) {
            $validated['evidence_image'] = $this->evidenceImageService->store(
                $request->file('evidence_image'),
                'evidences/wastes'
            );
        } else {
            unset($validated['evidence_image']);
        }

        $validated['user_id'] = Auth::id();

        $waste = Waste::create($validated);

        return redirect()
            ->route('wastes.byUnit', ['unit' => $waste->productive_unit_id])
            ->with('success', 'Residuo registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Waste $waste)
    {
        $waste->loadMissing(['productiveUnit', 'user']);

        return view('wastes::resol-show', compact('waste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waste $waste)
    {
        // Aprendiz solo puede editar sus propios registros
        // Cambio realizado por John
        if (Auth::user()->hasRole('Aprendiz') && $waste->user_id !== Auth::id()) {
            abort(403, 'No puedes editar registros de otros usuarios, solo lider ambiental.');
        }

        $unit = $waste->productiveUnit;

        return view('wastes::resol-edit', compact('waste', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWasteRequest $request, Waste $waste)
    {
        // Aprendiz solo puede actualizar sus propios registros
        if (Auth::user()->hasRole('Aprendiz') && $waste->user_id !== Auth::id()) {
            abort(403, 'No puedes editar registros de otros usuarios.');
        }

        $validated = $request->validated();

        if ($request->hasFile('evidence_image')) {
            $validated['evidence_image'] = $this->evidenceImageService->replace(
                $request->file('evidence_image'),
                'evidences/wastes',
                $waste->evidence_image
            );
        } else {
            unset($validated['evidence_image']);
        }

        $waste->update($validated);

        return redirect()
            ->route('wastes.byUnit', ['unit' => $waste->productive_unit_id])
            ->with('success', 'Residuo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Waste $waste)
    {
        $this->evidenceImageService->delete($waste->evidence_image);

        $unitId = $waste->productive_unit_id;
        $waste->delete();

        return redirect()
            ->route('wastes.byUnit', ['unit' => $unitId])
            ->with('success', 'Residuo eliminado correctamente.');
    }

    /**
     * List wastes by productive unit with DataTable friendly response.
     */
    public function byUnit(Request $request, ProductiveUnit $unit)
    {
        if ($request->ajax()) {
            $wastes = Waste::with('user')
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
                        'acciones' => view('wastes::partials.resol-actions', compact('waste'))->render(),
                    ];
                });

            return response()->json(['data' => $wastes]);
        }

        $dateBounds = Waste::query()
            ->where('productive_unit_id', $unit->id)
            ->selectRaw('MIN(entry_date) as min_entry_date, MAX(entry_date) as max_entry_date, COUNT(*) as total_records')
            ->first();

        $minEntryDate = $dateBounds?->min_entry_date
            ? Carbon::parse($dateBounds->min_entry_date)->format('Y-m-d')
            : null;

        $maxEntryDate = $dateBounds?->max_entry_date
            ? Carbon::parse($dateBounds->max_entry_date)->format('Y-m-d')
            : null;

        $hasRecords = (int) ($dateBounds?->total_records ?? 0) > 0;

        $availableYears = Waste::query()
            ->where('productive_unit_id', $unit->id)
            ->whereNotNull('entry_date')
            ->whereYear('entry_date', '<=', now()->year)
            ->selectRaw('YEAR(entry_date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->map(static fn ($year): int => (int) $year)
            ->values()
            ->all();

        return view('wastes::resol-index', compact('unit', 'minEntryDate', 'maxEntryDate', 'hasRecords', 'availableYears'));
    }

    /**
     * Build week label (Mon-Sun) for grouping.
     */
    private function weekLabel($date): string
    {
        $carbonDate = Carbon::parse($date);
        $start = $carbonDate->copy()->startOfWeek(Carbon::MONDAY);
        $end = $start->copy()->addDays(6);

        return 'Semana del '.$start->format('d/m/Y').' al '.$end->format('d/m/Y');
    }
}
