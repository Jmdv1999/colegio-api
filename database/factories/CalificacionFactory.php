<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Calificacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Calificacion>
 */
class CalificacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumno_id' => Alumno::factory(),
            'asignatura_id' => Asignatura::factory(),
            'calificacion' => fake()->randomFloat(2, 0, 20),
        ];
    }
}
