<?php

namespace Modules\Wastes\Services;

use Carbon\CarbonImmutable;

class WasteExportRangeService
{
    public function resolve(array $filters): array
    {
        return match ($filters['range_type']) {
            'annual' => $this->resolveAnnualRange((int) $filters['year']),
            'semiannual' => $this->resolveSemiannualRange((int) $filters['year'], (int) $filters['semester']),
            'quarterly' => $this->resolveQuarterlyRange((int) $filters['year'], (int) $filters['quarter']),
            'monthly' => $this->resolveMonthlyRange((int) $filters['year'], (int) $filters['month']),
            'weekly' => $this->resolveWeeklyRange($filters['start_date'], $filters['end_date']),
            'custom' => $this->resolveCustomRange($filters['start_date'], $filters['end_date']),
            default => throw new \InvalidArgumentException('Tipo de rango no soportado.'),
        };
    }

    private function resolveAnnualRange(int $year): array
    {
        $startDate = CarbonImmutable::create($year, 1, 1)->startOfDay();
        $endDate = $startDate->endOfYear()->endOfDay();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'range_label' => "Anual {$year}",
            'range_slug' => "anual_{$year}",
        ];
    }

    private function resolveSemiannualRange(int $year, int $semester): array
    {
        $startMonth = $semester === 1 ? 1 : 7;
        $startDate = CarbonImmutable::create($year, $startMonth, 1)->startOfDay();
        $endDate = $startDate->addMonths(5)->endOfMonth()->endOfDay();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'range_label' => "Semestre {$semester} de {$year}",
            'range_slug' => "semestral_{$year}_s{$semester}",
        ];
    }

    private function resolveQuarterlyRange(int $year, int $quarter): array
    {
        $startMonth = (($quarter - 1) * 3) + 1;
        $startDate = CarbonImmutable::create($year, $startMonth, 1)->startOfDay();
        $endDate = $startDate->addMonths(2)->endOfMonth()->endOfDay();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'range_label' => "Trimestre {$quarter} de {$year}",
            'range_slug' => "trimestral_{$year}_t{$quarter}",
        ];
    }

    private function resolveMonthlyRange(int $year, int $month): array
    {
        $startDate = CarbonImmutable::create($year, $month, 1)->startOfDay();
        $endDate = $startDate->endOfMonth()->endOfDay();
        $monthName = $this->monthName($month);

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'range_label' => "Mensual {$monthName} {$year}",
            'range_slug' => "mensual_{$year}_m".str_pad((string) $month, 2, '0', STR_PAD_LEFT),
        ];
    }

    private function resolveWeeklyRange(string $startDate, string $endDate): array
    {
        $start = CarbonImmutable::parse($startDate)->startOfDay();
        $end = CarbonImmutable::parse($endDate)->endOfDay();

        return [
            'start_date' => $start,
            'end_date' => $end,
            'range_label' => 'Semanal del '.$start->format('d/m/Y').' al '.$end->format('d/m/Y'),
            'range_slug' => 'semanal_'.$start->format('Ymd').'_'.$end->format('Ymd'),
        ];
    }

    private function resolveCustomRange(string $startDate, string $endDate): array
    {
        $start = CarbonImmutable::parse($startDate)->startOfDay();
        $end = CarbonImmutable::parse($endDate)->endOfDay();

        return [
            'start_date' => $start,
            'end_date' => $end,
            'range_label' => 'Personalizado del '.$start->format('d/m/Y').' al '.$end->format('d/m/Y'),
            'range_slug' => 'personalizado_'.$start->format('Ymd').'_'.$end->format('Ymd'),
        ];
    }

    private function monthName(int $month): string
    {
        return [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre',
        ][$month] ?? '';
    }
}
