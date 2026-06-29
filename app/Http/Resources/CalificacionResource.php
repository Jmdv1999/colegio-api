<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalificacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'calificacion' => $this->calificacion,
            'alumno' => new AlumnoResource($this->whenLoaded('alumno')),
            'asignatura' => new AsignaturaResource($this->whenLoaded('asignatura')),
        ];
    }
}
