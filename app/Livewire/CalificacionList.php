<?php

namespace App\Livewire;

use App\Models\Calificacion;
use Livewire\Component;

class CalificacionList extends Component
{
    public function render()
    {
        return view('livewire.calificacion-list', [
            'calificaciones' => Calificacion::all()
        ])->layout('components.layouts.app');
    }
}