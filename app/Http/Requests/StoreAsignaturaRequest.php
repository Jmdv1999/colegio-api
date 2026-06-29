<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAsignaturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $asignaturaId = $this->route('asignatura');
        $asignaturaId = is_object($asignaturaId) ? $asignaturaId->id : $asignaturaId;

        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('asignaturas', 'nombre')->ignore($asignaturaId),
            ],
            'descripcion' => 'required|string|max:500',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'nombre' => [
                'description' => 'Nombre de la asignatura',
                'example' => 'Matemática',
            ],
            'descripcion' => [
                'description' => 'Descripción de la asignatura',
                'example' => 'Curso de álgebra y geometría',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->replace(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->all()));
    }
}
