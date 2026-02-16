<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Models\HazardouWaste;
use Modules\Wastes\Models\Waste;

class DashboardController extends Controller
{
    public function index()
    {
        $totalResol = (int) Waste::query()->sum('amount');
        $totalRespel = (int) HazardouWaste::query()->sum('amount');
        $totalUsersWithoutRole = User::query()->doesntHave('roles')->count();

        $units = ProductiveUnit::query()
            ->select('id', 'name')
            ->withSum('wastes as resol_total_amount', 'amount')
            ->withSum('hazardouWastes as respel_total_amount', 'amount')
            ->orderBy('name')
            ->get();

        $unitLabels = $units->pluck('name')->values()->all();
        $resolByUnitSeries = $units
            ->map(fn (ProductiveUnit $unit): int => (int) ($unit->resol_total_amount ?? 0))
            ->values()
            ->all();
        $respelByUnitSeries = $units
            ->map(fn (ProductiveUnit $unit): int => (int) ($unit->respel_total_amount ?? 0))
            ->values()
            ->all();
        $pieSeries = [$totalResol, $totalRespel];

        return view('dashboard::index', compact(
            'totalResol',
            'totalRespel',
            'totalUsersWithoutRole',
            'pieSeries',
            'unitLabels',
            'resolByUnitSeries',
            'respelByUnitSeries',
        ));
    }
}
