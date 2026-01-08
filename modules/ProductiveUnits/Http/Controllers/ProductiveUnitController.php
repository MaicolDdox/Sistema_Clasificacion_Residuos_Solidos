<?php

namespace Modules\ProductiveUnits\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Areas\Models\Area;

class ProductiveUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = ProductiveUnit::with('area')->get()->map(function ($unit) {
                $wasteTypeLabel = match($unit->waste_type) {
                    'convencional' => 'Convencional',
                    'respel' => 'Respel',
                    'ambos' => 'Ambos',
                    default => 'No definido'
                };

                return [
                    'id'          => $unit->id,
                    'area'        => $unit->area?->name ?? 'Sin area',
                    'name'        => Str::limit($unit->name, 40),
                    'description' => Str::limit($unit->description, 60),
                    'waste_type'  => $wasteTypeLabel,
                    'created_at'  => $unit->created_at?->format('Y-m-d'),
                    'updated_at'  => $unit->updated_at?->format('Y-m-d'),
                    'acciones'    => view('ProductiveUnits::partials.productiveUnits-actions', compact('unit'))->render(),
                ];
            });

            return response()->json(['data' => $units]);
        }

        return view('ProductiveUnits::productiveUnits-list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::orderBy('name')->get();
        return view('ProductiveUnits::productiveUnits-create', compact('areas'));
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
            'waste_type' => 'required|in:convencional,respel,ambos',
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
        return view('ProductiveUnits::productiveUnits-detalles', compact('productiveUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductiveUnit $productiveUnit)
    {
        $areas = Area::orderBy('name')->get();
        return view('ProductiveUnits::productiveUnits-edit', compact('productiveUnit', 'areas'));
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
            'waste_type' => 'required|in:convencional,respel,ambos',
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
        $productiveUnit->delete();

        return redirect()->route('productive-units.index')
            ->with('success', 'Unidad productiva eliminada exitosamente.');
    }
}
