<?php

namespace App\Livewire;

use App\Models\Asignatura;
use Livewire\Component;

class AsignaturaList extends Component
{
    public function render()
    {
        return view('livewire.asignatura-list', [
            'asignaturas' => Asignatura::all()
        ])->layout('components.layouts.app');
    }
}