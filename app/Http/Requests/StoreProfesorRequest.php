<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfesorRequest extends FormRequest
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
        $profesor_id = $this->route()?->originalParameter('profesore') ?? $this->segment(3);

        return [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:12|regex:/^[0-9]+$/|unique:profesores,cedula,'.$profesor_id,
            'asignatura_id' => 'required|exists:asignaturas,id',
        ];
    }
}
