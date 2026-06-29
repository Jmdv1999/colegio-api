<?php

use App\Http\Controllers\Api\AlumnoController;
use App\Http\Controllers\Api\AsignaturaController;
use App\Http\Controllers\Api\CalificacionController;
use App\Http\Controllers\Api\ProfesorController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'alumnos' => AlumnoController::class,
    'asignaturas' => AsignaturaController::class,
    'profesores' => ProfesorController::class,
    'calificaciones' => CalificacionController::class,
]);
