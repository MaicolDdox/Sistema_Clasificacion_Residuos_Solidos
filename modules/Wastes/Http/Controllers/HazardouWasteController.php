<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Models\HazardouWaste;

class HazardouWasteController extends Controller
{
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'productive_unit_id' => ['required', 'exists:productive_units,id'],
            'entry_date' => ['required', 'date'],
            'waste_type' => ['required', 'in:Residuo Quimico,Residuo Biologico,Residuo Organico Peligroso'],
            'amount' => ['required', 'integer', 'min:1'],
            'observations' => ['nullable', 'string'],
        ]);

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
        $unit = $hazardouWaste->productiveUnit;

        return view('wastes::respel-edit', compact('hazardouWaste', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HazardouWaste $hazardouWaste)
    {
        $validated = $request->validate([
            'entry_date' => ['required', 'date'],
            'waste_type' => ['required', 'in:Residuo Quimico,Residuo Biologico,Residuo Organico Peligroso'],
            'amount' => ['required', 'integer', 'min:1'],
            'observations' => ['nullable', 'string'],
        ]);

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
