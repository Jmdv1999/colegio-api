<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use App\Models\Profesor;
use Illuminate\Database\Seeder;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asignaturas = Asignatura::all();
        foreach ($asignaturas as $asignatura) {
            Profesor::factory()->create(['asignatura_id' => $asignatura->id]);
        }
    }
}
