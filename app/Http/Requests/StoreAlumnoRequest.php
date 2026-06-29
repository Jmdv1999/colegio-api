<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlumnoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $alumnoId = $this->route('alumno')?->id
                ?? $this->input('id')
                ?? $this->segment(3);

        return [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => [
                'required',
                'string',
                'max:12',
                'regex:/^[0-9]+$/',
                Rule::unique('alumnos', 'cedula')->ignore($alumnoId),
            ],
            'nacimiento' => 'required|date|before:today',
        ];
    }
}
