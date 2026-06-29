<?php

namespace App\Livewire;
use App\Models\Profesor;
use Livewire\Component;

class ProfesorList extends Component
{
    public function render() {
        return view('livewire.profesor-list', [
            'profesores' => Profesor::with('asignatura')->get()
        ])->layout('components.layouts.app');
    }
}