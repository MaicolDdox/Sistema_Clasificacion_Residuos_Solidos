<?php

namespace Modules\Wastes\Services;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Models\HazardouWaste;
use Modules\Wastes\Models\Waste;

class WasteExportQueryService
{
    public function resolRangeQuery(ProductiveUnit $unit, CarbonInterface $startDate, CarbonInterface $endDate): Builder
    {
        return $this->baseQuery(Waste::class, 'wastes')
            ->where('wastes.productive_unit_id', $unit->id)
            ->whereBetween('wastes.entry_date', [
                $startDate->toDateTimeString(),
                $endDate->toDateTimeString(),
            ]);
    }

    public function respelRangeQuery(ProductiveUnit $unit, CarbonInterface $startDate, CarbonInterface $endDate): Builder
    {
        return $this->baseQuery(HazardouWaste::class, 'hazardou_wastes')
            ->where('hazardou_wastes.productive_unit_id', $unit->id)
            ->whereBetween('hazardou_wastes.entry_date', [
                $startDate->toDateTimeString(),
                $endDate->toDateTimeString(),
            ]);
    }

    public function resolSingleQuery(int $wasteId): Builder
    {
        return $this->baseQuery(Waste::class, 'wastes')
            ->where('wastes.id', $wasteId);
    }

    public function respelSingleQuery(int $wasteId): Builder
    {
        return $this->baseQuery(HazardouWaste::class, 'hazardou_wastes')
            ->where('hazardou_wastes.id', $wasteId);
    }

    private function baseQuery(string $modelClass, string $table): Builder
    {
        return $modelClass::query()
            ->join('productive_units', "{$table}.productive_unit_id", '=', 'productive_units.id')
            ->leftJoin('users', "{$table}.user_id", '=', 'users.id')
            ->select([
                "{$table}.id",
                "{$table}.entry_date",
                "{$table}.waste_type",
                "{$table}.amount",
                "{$table}.observations",
                'productive_units.name as productive_unit_name',
                'users.name as responsible_name',
            ])
            ->orderBy("{$table}.entry_date");
    }
}
