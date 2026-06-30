<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use Illuminate\Database\Seeder;

class AsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = ['Matemáticas', 'Historia', 'Física', 'Química', 'Literatura'];

        foreach ($materias as $materia) {
            Asignatura::firstOrCreate(
                ['nombre' => $materia],
                ['descripcion' => "Clase de $materia."]
            );
        }
    }
}
