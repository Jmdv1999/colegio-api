<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Calificacion;
use Illuminate\Database\Seeder;

class CalificacionSeeder extends Seeder
{
  public function run(): void
{
    $Alumnos = Alumno::all();
    $Asignaturas = Asignatura::all();

    $combinaciones = [];

    foreach ($Alumnos as $alumno) {
        foreach ($Asignaturas as $asignatura) {
            $combinaciones[] = [
                'alumno_id' => $alumno->id,
                'asignatura_id' => $asignatura->id,
            ];
        }
    }

    shuffle($combinaciones);

    $cantidadRegistros = 20;
    $seleccionadas = array_slice($combinaciones, 0, min($cantidadRegistros, count($combinaciones)));

    foreach ($seleccionadas as $par) {
        Calificacion::factory()->create([
            'alumno_id' => $par['alumno_id'],
            'asignatura_id' => $par['asignatura_id'],
        ]);
    }
}
}
