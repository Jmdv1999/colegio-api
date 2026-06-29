<?php

namespace App\Livewire;

use App\Models\Alumno;
use Livewire\Component;
use Livewire\WithPagination;

class AlumnoList extends Component
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
        $query = Alumno::query();

        if ($this->sortColumn === 'edad') {
            $query->orderByRaw('TIMESTAMPDIFF(YEAR, nacimiento, CURDATE()) '.$this->sortDirection);
        } else {
            $query->orderBy($this->sortColumn, $this->sortDirection);
        }

        $alumnos = $query->paginate(10);

        return view('livewire.alumno-list', compact('alumnos'))
            ->layout('components.layouts.app');
    }
}
