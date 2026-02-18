<?php

namespace Modules\Areas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:areas,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del área es obligatorio.',
            'name.string' => 'El nombre del área debe ser un texto válido.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'name.unique' => 'Ya existe un área con este nombre.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
        ];
    }
}
