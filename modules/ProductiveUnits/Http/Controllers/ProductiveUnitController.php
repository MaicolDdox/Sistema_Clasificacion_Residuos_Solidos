<?php

namespace Modules\ProductiveUnits\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Areas\Models\Area;
use Modules\ProductiveUnits\Models\ProductiveUnit;

class ProductiveUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = ProductiveUnit::query()
                ->with('area')
                ->withCount(['wastes', 'hazardouWastes'])
                ->orderBy('name')
                ->get()
                ->map(function ($unit) {
                    $wasteTypeLabel = match($unit->waste_type) {
                        'Residuos Solidos' => 'Residuos Solidos (RESOL)',
                        'Residuos Peligrosos' => 'Residuos Peligrosos (RESPEL)',
                        'RESOL/RESPEL' => 'Ambos (RESOL/RESPEL)',
                        default => 'No definido',
                    };

                    return [
                        'id'          => $unit->id,
                        'area'        => Str::limit($unit->area?->name ?? 'Sin area', 40),
                        'name'        => Str::limit($unit->name, 40),
                        'description' => Str::limit($unit->description, 60),
                        'waste_type'  => $wasteTypeLabel,
                        'created_at'  => $unit->created_at?->format('Y-m-d'),
                        'updated_at'  => $unit->updated_at?->format('Y-m-d'),
                        'mobile_info' => view('productiveunits::partials.productiveUnits-mobile-info', [
                            'description' => Str::limit((string) $unit->description, 90),
                        ])->render(),
                        'acciones'    => view('productiveunits::partials.productiveUnits-actions', compact('unit'))->render(),
                    ];
                });

            return response()->json(['data' => $units]);
        }

        return view('productiveunits::productiveUnits-list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::orderBy('name')->get();
        return view('productiveunits::productiveUnits-create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => 'required|exists:areas,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'waste_type' => 'required|in:Residuos Solidos,Residuos Peligrosos,RESOL/RESPEL',
        ]);

        ProductiveUnit::create($validated);

        return redirect()->route('productive-units.index')
            ->with('success', 'Unidad productiva creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductiveUnit $productiveUnit)
    {
        $productiveUnit->load('area');
        return view('productiveunits::productiveUnits-detalles', compact('productiveUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductiveUnit $productiveUnit)
    {
        $areas = Area::orderBy('name')->get();
        return view('productiveunits::productiveUnits-edit', compact('productiveUnit', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductiveUnit $productiveUnit)
    {
        $validated = $request->validate([
            'area_id' => 'required|exists:areas,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'waste_type' => 'required|in:Residuos Solidos,Residuos Peligrosos,RESOL/RESPEL',
        ]);

        $productiveUnit->update($validated);

        return redirect()->route('productive-units.index')
            ->with('success', 'Unidad productiva actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductiveUnit $productiveUnit)
    {
        $productiveUnit->loadCount(['wastes', 'hazardouWastes']);
        $relatedRecordsCount = (int) $productiveUnit->wastes_count + (int) $productiveUnit->hazardou_wastes_count;

        if ($relatedRecordsCount > 0) {
            return redirect()->route('productive-units.index')
                ->with('error', 'No se puede eliminar la unidad porque tiene registros de residuos asociados.');
        }

        try {
            $productiveUnit->delete();

            return redirect()->route('productive-units.index')
                ->with('success', 'Unidad productiva eliminada exitosamente.');
        } catch (QueryException $exception) {
            return redirect()->route('productive-units.index')
                ->with('error', 'No se pudo eliminar la unidad porque tiene relaciones activas en el sistema.');
        }
    }
}
