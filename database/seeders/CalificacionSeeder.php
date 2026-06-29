<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Calificacion;
use Illuminate\Database\Seeder;

class CalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Calificacion::factory(20)->make()->each(function ($calificacion) {
            $calificacion->alumno_id = Alumno::inRandomOrder()->first()->id;
            $calificacion->asignatura_id = Asignatura::inRandomOrder()->first()->id;
            $calificacion->save();
        });
    }
}
