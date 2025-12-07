<?php

namespace Modules\ProductiveUnits\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\ProductiveUnits\Models\ProductiveUnit;

class ProductiveUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = ProductiveUnit::with('area')->get()->map(function ($unit) {
                return [
                    'id'          => $unit->id,
                    'area'        => $unit->area?->name ?? 'Sin area',
                    'name'        => Str::limit($unit->name, 40),
                    'description' => Str::limit($unit->description, 60),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductiveUnit $productiveUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductiveUnit $productiveUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductiveUnit $productiveUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductiveUnit $productiveUnit)
    {
        //
    }
}
