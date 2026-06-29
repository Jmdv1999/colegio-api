<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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

    protected function prepareForValidation(): void
    {
        $this->replace(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->all()));
    }
}
