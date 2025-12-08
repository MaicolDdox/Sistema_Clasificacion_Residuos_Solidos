<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Areas\Models\Area;
use Modules\ProductiveUnits\Models\ProductiveUnit;

class WasteNavigatorController extends Controller
{
    /**
     * List units by area with AJAX for DataTable and full view otherwise.
     */
    public function unitsByArea(Request $request, Area $area)
    {
        if ($request->ajax()) {
            $units = ProductiveUnit::where('area_id', $area->id)
                ->orderBy('name')
                ->get()
                ->map(function ($unit) {
                    return [
                        'name' => Str::limit($unit->name, 80),
                        'acciones' => view('wastes::partials.unit-actions', compact('unit'))->render(),
                    ];
                });

            return response()->json(['data' => $units]);
        }

        return view('wastes::units-by-area', compact('area'));
    }
}
