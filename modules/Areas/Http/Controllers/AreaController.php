<?php

namespace Modules\Areas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Areas\Models\Area;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Si la petición es AJAX (desde DataTable)
        if ($request->ajax()) {
            $areas = Area::all()->map(function ($area) {
                return [
                    'id'           => $area->id,
                    'name'         => Str::limit($area->name, 30),
                    'description'  => Str::limit($area->description, 60),
                    'created_at'   => $area->created_at->format('Y-m-d'),
                    'updated_at'   => $area->updated_at->format('Y-m-d'),
                    'acciones'     => view('areas::partials.areas-actions', compact('area'))->render(),
                ];
            });

            return response()->json(['data' => $areas]);
        }

        // Si no es AJAX, devuelve la vista normal
        return view('areas::areas-list');
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
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        //
    }
}
