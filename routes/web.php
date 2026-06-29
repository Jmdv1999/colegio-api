<?php

use App\Livewire\AlumnoList;
use App\Livewire\AsignaturaList;
use App\Livewire\CalificacionList;
use App\Livewire\ProfesorList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/alumnos');
});

Route::get('/alumnos', AlumnoList::class);
Route::get('/asignaturas', AsignaturaList::class);
Route::get('/profesores', ProfesorList::class);
Route::get('/calificaciones', CalificacionList::class);
