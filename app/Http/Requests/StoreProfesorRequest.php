<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfesorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $profesorId = $this->route('profesore');
        $profesorId = is_object($profesorId) ? $profesorId->id : $profesorId;

        return [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => [
                'required',
                'string',
                'max:12',
                'regex:/^[0-9]+$/',
                Rule::unique('profesores', 'cedula')->ignore($profesorId),
            ],
            'asignatura_id' => 'required|exists:asignaturas,id',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'nombre' => [
                'description' => 'Nombre del profesor',
                'example' => 'Carlos',
            ],
            'apellido' => [
                'description' => 'Apellido del profesor',
                'example' => 'González',
            ],
            'cedula' => [
                'description' => 'Cédula de identidad (solo números, formato venezolano)',
                'example' => '87654321',
            ],
            'asignatura_id' => [
                'description' => 'ID de la asignatura que dicta',
                'example' => 1,
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->replace(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->all()));
    }
}
