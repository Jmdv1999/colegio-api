<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $alumnoId = $this->route('alumno');
        $alumnoId = is_object($alumnoId) ? $alumnoId->id : $alumnoId;

        return [
            'nombre' => 'sometimes|required|string|max:100',
            'apellido' => 'sometimes|required|string|max:100',
            'cedula' => [
                'sometimes',
                'required',
                'string',
                'max:12',
                'regex:/^[0-9]+$/',
                Rule::unique('alumnos', 'cedula')->ignore($alumnoId),
            ],
            'nacimiento' => 'sometimes|required|date|before:today',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->replace(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->all()));
    }
}
