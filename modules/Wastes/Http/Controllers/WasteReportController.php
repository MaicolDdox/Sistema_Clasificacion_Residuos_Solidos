<?php

namespace Modules\Wastes\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Models\HazardouWaste;
use Modules\Wastes\Models\Waste;

class WasteReportController extends Controller
{
    public function resolReport(ProductiveUnit $unit)
    {
        $wastes = Waste::with('user')
            ->where('productive_unit_id', $unit->id)
            ->orderBy('entry_date')
            ->get();

        [
            'byDay' => $byDay,
            'byType' => $byType,
            'byWeek' => $byWeek,
            'byMonth' => $byMonth,
            'byUser' => $byUser,
        ] = $this->buildDatasets($wastes);

        return view('wastes::reports.resol-report', [
            'unit' => $unit,
            'color' => '#10b981', // emerald
            'byDay' => $byDay,
            'byType' => $byType,
            'byWeek' => $byWeek,
            'byMonth' => $byMonth,
            'byUser' => $byUser,
        ]);
    }

    public function respelReport(ProductiveUnit $unit)
    {
        $wastes = HazardouWaste::with('user')
            ->where('productive_unit_id', $unit->id)
            ->orderBy('entry_date')
            ->get();

        [
            'byDay' => $byDay,
            'byType' => $byType,
            'byWeek' => $byWeek,
            'byMonth' => $byMonth,
            'byUser' => $byUser,
        ] = $this->buildDatasets($wastes);

        return view('wastes::reports.respel-report', [
            'unit' => $unit,
            'color' => '#f43f5e', // rose
            'byDay' => $byDay,
            'byType' => $byType,
            'byWeek' => $byWeek,
            'byMonth' => $byMonth,
            'byUser' => $byUser,
        ]);
    }

    /**
     * @return array{byDay: array, byType: array, byWeek: array, byMonth: array, byUser: array}
     */
    private function buildDatasets(Collection $wastes): array
    {
        $byDay = $wastes->groupBy(fn ($w) => Carbon::parse($w->entry_date)->format('Y-m-d'))
            ->map(fn ($rows) => $rows->sum('amount'));

        $byType = $wastes->groupBy('waste_type')
            ->map(fn ($rows) => $rows->sum('amount'));

        $byWeek = $wastes->groupBy(function ($w) {
            $date = Carbon::parse($w->entry_date);
            $start = $date->copy()->startOfWeek(Carbon::MONDAY);
            $end = $start->copy()->addDays(6);
            return $start->format('Y-m-d').'|'.$end->format('Y-m-d');
        })->map(fn ($rows) => $rows->sum('amount'));

        $byMonth = $wastes->groupBy(fn ($w) => Carbon::parse($w->entry_date)->format('Y-m'))
            ->map(fn ($rows) => $rows->sum('amount'));

        $byUser = $wastes->groupBy(fn ($w) => $w->user?->name ?? 'Sin usuario')
            ->map(fn ($rows) => $rows->sum('amount'));

        return [
            'byDay' => [
                'categories' => $byDay->keys()->values(),
                'series' => $byDay->values()->map(fn ($v) => (int) $v),
            ],
            'byType' => [
                'labels' => $byType->keys()->values(),
                'series' => $byType->values()->map(fn ($v) => (int) $v),
            ],
            'byWeek' => [
                'categories' => $byWeek->keys()->map(function ($key) {
                    [$start, $end] = explode('|', $key);
                    return 'Semana '.$start.' al '.$end;
                })->values(),
                'series' => $byWeek->values()->map(fn ($v) => (int) $v),
            ],
            'byMonth' => [
                'categories' => $byMonth->keys()->values(),
                'series' => $byMonth->values()->map(fn ($v) => (int) $v),
            ],
            'byUser' => [
                'labels' => $byUser->keys()->values(),
                'series' => $byUser->values()->map(fn ($v) => (int) $v),
            ],
        ];
    }
}
