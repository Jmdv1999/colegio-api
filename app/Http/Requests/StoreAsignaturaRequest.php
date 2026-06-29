<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAsignaturaRequest extends FormRequest
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
        $asignatura_id = $this->route()?->originalParameter('asignatura') ?? $this->segment(3);

        return [
            'nombre' => 'required|string|max:100|unique:asignaturas,nombre,'.$asignatura_id,
            'descripcion' => 'required|string|max:500',
        ];
    }
}
