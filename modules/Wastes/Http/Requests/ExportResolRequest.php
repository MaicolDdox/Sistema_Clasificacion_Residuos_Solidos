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
        return [
            'range_type' => ['required', 'in:annual,semiannual,quarterly,monthly,weekly,custom'],
            'year' => ['required_if:range_type,annual,semiannual,quarterly,monthly', 'integer', 'digits:4', 'min:2000', 'max:2100'],
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
            'year.required_if' => 'El año es obligatorio para el rango seleccionado.',
            'year.integer' => 'El año debe ser numérico.',
            'year.digits' => 'El año debe tener 4 dígitos.',
            'year.min' => 'El año no puede ser menor a 2000.',
            'year.max' => 'El año no puede ser mayor a 2100.',
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
            if ($this->input('range_type') !== 'weekly') {
                if ($this->input('range_type') !== 'custom') {
                    return;
                }
            }

            if (! $this->filled('start_date') || ! $this->filled('end_date')) {
                return;
            }

            $startDate = Carbon::parse($this->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($this->input('end_date'))->endOfDay();
            $today = now()->endOfDay();

            if ($this->input('range_type') === 'weekly') {
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

            if ($this->input('range_type') === 'custom') {
                if ($startDate->greaterThan($today)) {
                    $validator->errors()->add('start_date', 'La fecha de inicio no puede ser futura.');
                }

                if ($endDate->greaterThan($today)) {
                    $validator->errors()->add('end_date', 'La fecha de fin no puede ser futura.');
                }

                $unitId = $this->resolveUnitId();

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
}
