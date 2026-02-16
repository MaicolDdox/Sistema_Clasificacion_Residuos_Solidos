<?php

namespace Modules\Wastes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHazardouWasteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'entry_date' => ['required', 'date'],
            'waste_type' => ['required', 'in:Residuo Quimico,Residuo Biologico,Residuo Organico Peligroso'],
            'amount' => ['required', 'integer', 'min:1'],
            'observations' => ['nullable', 'string'],
            'evidence_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'entry_date.required' => 'Debe ingresar la fecha y hora de entrada.',
            'entry_date.date' => 'La fecha y hora de entrada debe tener un formato válido.',
            'waste_type.required' => 'Debe seleccionar un tipo de residuo.',
            'waste_type.in' => 'El tipo de residuo seleccionado no es válido.',
            'amount.required' => 'Debe ingresar la cantidad.',
            'amount.integer' => 'La cantidad debe ser un número entero.',
            'amount.min' => 'La cantidad debe ser mayor o igual a 1.',
            'observations.string' => 'Las observaciones deben ser texto.',
            'evidence_image.image' => 'La imagen de evidencia debe ser un archivo de imagen válido.',
            'evidence_image.mimes' => 'La imagen de evidencia debe estar en formato jpeg, jpg, png o webp.',
            'evidence_image.max' => 'La imagen de evidencia no debe superar los 5 MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productive_unit_id' => 'unidad productiva',
            'entry_date' => 'fecha y hora de entrada',
            'waste_type' => 'tipo de residuo',
            'amount' => 'cantidad',
            'observations' => 'observaciones',
            'evidence_image' => 'imagen de evidencia',
        ];
    }
}
