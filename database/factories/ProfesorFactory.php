<?php

namespace Database\Factories;

use App\Models\Profesor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profesor>
 */
class ProfesorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
        'nombre' => fake()->firstName(),
        'apellido' => fake()->lastName(),
        'cedula' => fake()->unique()->numerify('###########'),
        'asignatura_id' => \App\Models\Asignatura::factory(),
    ];
    }
}
