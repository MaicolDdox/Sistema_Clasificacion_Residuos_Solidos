<?php

namespace Modules\Wastes\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Wastes\Models\Waste;

class ExportResolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $currentYear = now()->year;

        return [
            'range_type' => ['required', 'in:annual,semiannual,quarterly,monthly,weekly,custom'],
            'year' => ['required_if:range_type,annual,semiannual,quarterly,monthly', 'integer', 'digits:4', 'min:1900', "max:{$currentYear}"],
            'semester' => ['required_if:range_type,semiannual', 'integer', 'in:1,2'],
            'quarter' => ['required_if:range_type,quarterly', 'integer', 'in:1,2,3,4'],
            'month' => ['required_if:range_type,monthly', 'integer', 'between:1,12'],
            'start_date' => ['required_if:range_type,weekly,custom', 'date'],
            'end_date' => ['required_if:range_type,weekly,custom', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'range_type.required' => 'Debe seleccionar un tipo de rango.',
            'range_type.in' => 'El tipo de rango seleccionado no es válido.',
            'year.required_if' => 'Selecciona un año válido.',
            'year.integer' => 'El año debe ser numérico.',
            'year.digits' => 'El año debe tener 4 dígitos.',
            'year.min' => 'El año no puede ser menor a 1900.',
            'year.max' => 'El año no puede ser mayor al año actual.',
            'semester.required_if' => 'Debe seleccionar el semestre.',
            'semester.in' => 'El semestre seleccionado no es válido.',
            'quarter.required_if' => 'Debe seleccionar el trimestre.',
            'quarter.in' => 'El trimestre seleccionado no es válido.',
            'month.required_if' => 'Debe seleccionar el mes.',
            'month.between' => 'El mes seleccionado no es válido.',
            'start_date.required_if' => 'La fecha de inicio es obligatoria para el rango seleccionado.',
            'start_date.date' => 'La fecha de inicio no tiene un formato válido.',
            'end_date.required_if' => 'La fecha de fin es obligatoria para el rango seleccionado.',
            'end_date.date' => 'La fecha de fin no tiene un formato válido.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        ];
    }

    public function attributes(): array
    {
        return [
            'range_type' => 'tipo de rango',
            'year' => 'año',
            'semester' => 'semestre',
            'quarter' => 'trimestre',
            'month' => 'mes',
            'start_date' => 'fecha de inicio',
            'end_date' => 'fecha de fin',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $rangeType = $this->input('range_type');
            $unitId = $this->resolveUnitId();
            $yearBasedRanges = ['annual', 'semiannual', 'quarterly', 'monthly'];

            if (in_array($rangeType, $yearBasedRanges, true) && $this->filled('year') && is_numeric($this->input('year'))) {
                $year = (int) $this->input('year');
                $currentYear = now()->year;

                if ($year > $currentYear) {
                    $validator->errors()->add('year', 'El año no puede ser mayor al año actual.');
                    return;
                }

                if ($unitId !== null) {
                    $hasYearData = Waste::query()
                        ->where('productive_unit_id', $unitId)
                        ->whereYear('entry_date', $year)
                        ->exists();

                    if (! $hasYearData) {
                        $validator->errors()->add('year', 'No hay registros en el año seleccionado.');
                        return;
                    }

                    if (in_array($rangeType, ['semiannual', 'quarterly', 'monthly'], true)) {
                        $rangeDates = $this->resolvePeriodicDates($rangeType, $year);

                        if ($rangeDates !== null) {
                            [$startDate, $endDate] = $rangeDates;

                            $hasRangeData = Waste::query()
                                ->where('productive_unit_id', $unitId)
                                ->whereBetween('entry_date', [
                                    $startDate->toDateTimeString(),
                                    $endDate->toDateTimeString(),
                                ])
                                ->exists();

                            if (! $hasRangeData) {
                                $validator->errors()->add('start_date', 'No hay registros en el rango seleccionado.');
                            }
                        }
                    }
                }
            }

            if (! in_array($rangeType, ['weekly', 'custom'], true)) {
                return;
            }

            if (! $this->filled('start_date') || ! $this->filled('end_date')) {
                return;
            }

            $startDate = Carbon::parse($this->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($this->input('end_date'))->endOfDay();
            $today = now()->endOfDay();

            if ($rangeType === 'weekly') {
                if (! $startDate->isMonday()) {
                    $validator->errors()->add('start_date', 'La fecha de inicio debe corresponder a un lunes.');
                }

                if (! $endDate->isSunday()) {
                    $validator->errors()->add('end_date', 'La fecha de fin debe corresponder a un domingo.');
                }

                if ($startDate->diffInDays($endDate) !== 6) {
                    $validator->errors()->add('end_date', 'El rango semanal debe tener exactamente 7 días (lunes a domingo).');
                }
            }

            if ($rangeType === 'custom') {
                if ($startDate->greaterThan($today)) {
                    $validator->errors()->add('start_date', 'La fecha de inicio no puede ser futura.');
                }

                if ($endDate->greaterThan($today)) {
                    $validator->errors()->add('end_date', 'La fecha de fin no puede ser futura.');
                }

                if ($unitId !== null) {
                    $exists = Waste::query()
                        ->where('productive_unit_id', $unitId)
                        ->whereBetween('entry_date', [
                            $startDate->toDateTimeString(),
                            $endDate->toDateTimeString(),
                        ])
                        ->exists();

                    if (! $exists) {
                        $validator->errors()->add('start_date', 'No hay registros en el rango seleccionado.');
                    }
                }
            }
        });
    }

    private function resolveUnitId(): ?int
    {
        $unit = $this->route('unit');

        if (is_object($unit) && isset($unit->id)) {
            return (int) $unit->id;
        }

        if (is_numeric($unit)) {
            return (int) $unit;
        }

        return null;
    }

    private function resolvePeriodicDates(string $rangeType, int $year): ?array
    {
        if ($rangeType === 'semiannual') {
            $semester = (int) $this->input('semester');
            if (! in_array($semester, [1, 2], true)) {
                return null;
            }

            $startMonth = $semester === 1 ? 1 : 7;
            $endMonth = $semester === 1 ? 6 : 12;

            return [
                Carbon::create($year, $startMonth, 1)->startOfDay(),
                Carbon::create($year, $endMonth, 1)->endOfMonth()->endOfDay(),
            ];
        }

        if ($rangeType === 'quarterly') {
            $quarter = (int) $this->input('quarter');
            if ($quarter < 1 || $quarter > 4) {
                return null;
            }

            $startMonth = (($quarter - 1) * 3) + 1;
            $endMonth = $startMonth + 2;

            return [
                Carbon::create($year, $startMonth, 1)->startOfDay(),
                Carbon::create($year, $endMonth, 1)->endOfMonth()->endOfDay(),
            ];
        }

        if ($rangeType === 'monthly') {
            $month = (int) $this->input('month');
            if ($month < 1 || $month > 12) {
                return null;
            }

            return [
                Carbon::create($year, $month, 1)->startOfDay(),
                Carbon::create($year, $month, 1)->endOfMonth()->endOfDay(),
            ];
        }

        return null;
    }
}
