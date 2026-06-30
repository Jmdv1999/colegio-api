<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alumno_id' => 'sometimes|required|exists:alumnos,id',
            'asignatura_id' => 'sometimes|required|exists:asignaturas,id',
            'calificacion' => 'sometimes|required|numeric|between:0,20',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'alumno_id' => [
                'description' => 'ID del alumno',
                'example' => 1,
            ],
            'asignatura_id' => [
                'description' => 'ID de la asignatura',
                'example' => 1,
            ],
            'calificacion' => [
                'description' => 'Nota del alumno (0 a 20)',
                'example' => 15.5,
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->replace(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->all()));
    }
}
