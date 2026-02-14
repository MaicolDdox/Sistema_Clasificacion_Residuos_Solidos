<?php

namespace Modules\Wastes\Exports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WasteRowsExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(
        private readonly Builder $query
    ) {}

    public function query(): Builder
    {
        return clone $this->query;
    }

    public function headings(): array
    {
        return [
            'Fecha de entrada',
            'Unidad productiva',
            'Tipo de residuo',
            'Cantidad',
            'Observaciones',
            'Responsable',
        ];
    }

    public function map($row): array
    {
        return [
            Carbon::parse($row->entry_date)->format('d/m/Y H:i'),
            $row->productive_unit_name,
            $row->waste_type,
            $row->amount,
            $row->observations ?? 'Sin observaciones',
            $row->responsible_name ?? 'Sin usuario',
        ];
    }
}
