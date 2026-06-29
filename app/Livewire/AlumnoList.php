<?php

namespace App\Livewire;

use App\Models\Alumno;
use Livewire\Component;

class AlumnoList extends Component
{
    public function render()
    {
        return view('livewire.alumno-list', [
            'alumnos' => Alumno::all()
        ])->layout('components.layouts.app');
    }
}