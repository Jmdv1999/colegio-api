<?php

namespace App\Livewire;

use App\Models\Asignatura;
use Livewire\Component;
use Livewire\WithPagination;

class AsignaturaList extends Component
{
    use WithPagination;
      public $sortColumn = 'nombre';

    public $sortDirection = 'asc';

    
    public function sortBy($column)
    {
        $this->sortDirection = ($this->sortColumn == $column && $this->sortDirection == 'asc') ? 'desc' : 'asc';
        $this->sortColumn = $column;
    }
    public function render()
    {
        return view('livewire.asignatura-list', [
            'asignaturas' => Asignatura::orderBy($this->sortColumn, $this->sortDirection)->paginate(10)
        ])->layout('components.layouts.app');
    }
}