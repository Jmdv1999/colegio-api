<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfesorRequest extends FormRequest
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
            'nombre' => 'sometimes|required|string|max:100',
            'apellido' => 'sometimes|required|string|max:100',
            'cedula' => [
                'sometimes',
                'required',
                'string',
                'max:12',
                'regex:/^[0-9]+$/',
                Rule::unique('profesores', 'cedula')->ignore($profesorId),
            ],
            'asignatura_id' => 'sometimes|required|exists:asignaturas,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->replace(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->all()));
    }
}
