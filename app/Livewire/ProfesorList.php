<?php

namespace App\Livewire;

use App\Models\Profesor;
use Livewire\Component;
use Livewire\WithPagination;

class ProfesorList extends Component
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
        $query = Profesor::query();

        if ($this->sortColumn === 'asignatura.nombre') {
            $query->join('asignaturas', 'profesores.asignatura_id', '=', 'asignaturas.id')
                ->orderBy('asignaturas.nombre', $this->sortDirection)
                ->select('profesores.*');
        } else {
            $query->orderBy($this->sortColumn, $this->sortDirection);
        }

        return view('livewire.profesor-list', [
            'profesores' => $query->paginate(10),
        ])->layout('components.layouts.app');
    }
}
