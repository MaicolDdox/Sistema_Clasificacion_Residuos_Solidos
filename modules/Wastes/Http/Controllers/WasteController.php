<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Models\Waste;

class WasteController extends Controller
{
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'productive_unit_id' => ['required', 'exists:productive_units,id'],
            'entry_date' => ['required', 'date'],
            'waste_type' => ['required', 'in:Residuo Organico,Residuo Ordinarios,Residuo Reciclables'],
            'amount' => ['required', 'integer', 'min:1'],
            'observations' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();

        $waste = Waste::create($validated);

        return redirect()
            ->route('wastes.byUnit', ['unit' => $waste->productive_unit_id])
            ->with('success', 'Residuo registrado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waste $waste)
    {
        $unit = $waste->productiveUnit;

        return view('wastes::resol-edit', compact('waste', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Waste $waste)
    {
        $validated = $request->validate([
            'entry_date' => ['required', 'date'],
            'waste_type' => ['required', 'in:Residuo Organico,Residuo Ordinarios,Residuo Reciclables'],
            'amount' => ['required', 'integer', 'min:1'],
            'observations' => ['nullable', 'string'],
        ]);

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

        return view('wastes::resol-index', compact('unit'));
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
