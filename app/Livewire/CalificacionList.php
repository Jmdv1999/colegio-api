<?php

namespace App\Livewire;

use App\Models\Calificacion;
use Livewire\Component;
use Livewire\WithPagination;

class CalificacionList extends Component
{
    use WithPagination;

    public $sortColumn = 'calificacion';

    public $sortDirection = 'desc';

    public function sortBy($column)
    {
        $this->sortDirection = ($this->sortColumn == $column && $this->sortDirection == 'asc') ? 'desc' : 'asc';
        $this->sortColumn = $column;
    }

    public function render()
    {
        $query = Calificacion::query();

        if ($this->sortColumn === 'alumno.nombre') {
            $query->join('alumnos', 'calificaciones.alumno_id', '=', 'alumnos.id')
                ->orderBy('alumnos.nombre', $this->sortDirection)
                ->select('calificaciones.*');
        } elseif ($this->sortColumn === 'asignatura.nombre') {
            $query->join('asignaturas', 'calificaciones.asignatura_id', '=', 'asignaturas.id')
                ->orderBy('asignaturas.nombre', $this->sortDirection)
                ->select('calificaciones.*');
        } else {
            $query->orderBy($this->sortColumn, $this->sortDirection);
        }

        return view('livewire.calificacion-list', [
            'calificaciones' => $query->paginate(10),
        ])->layout('components.layouts.app');
    }
}
