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
        return view('areas::areas-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:areas,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'El nombre del área es obligatorio.',
            'name.unique' => 'Ya existe un área con este nombre.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
        ]);

        try {
            Area::create($validated);
            return redirect()->route('areas.index')
                ->with('success', 'Área creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el área: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        return view('areas::areas-detalles', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        return view('areas::areas-edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:areas,name,' . $area->id],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'El nombre del área es obligatorio.',
            'name.unique' => 'Ya existe un área con este nombre.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
        ]);

        try {
            $area->update($validated);
            return redirect()->route('areas.index')
                ->with('success', 'Área actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el área: ' . $e->getMessage());
        }
    }

    /**
     * Show the confirmation page for deleting the specified resource.
     */
    public function confirmDestroy(Area $area)
    {
        return view('areas::areas-delete', compact('area'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        try {
            // Verificar si tiene unidades productivas asociadas
            if ($area->productiveUnits()->count() > 0) {
                return redirect()->route('areas.index')
                    ->with('error', 'No se puede eliminar el área porque tiene unidades productivas asociadas.');
            }

            $area->delete();
            return redirect()->route('areas.index')
                ->with('success', 'Área eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('areas.index')
                ->with('error', 'Error al eliminar el área: ' . $e->getMessage());
        }
    }
}
