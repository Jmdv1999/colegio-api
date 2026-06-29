<?php

namespace App\Livewire;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Calificacion;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CalificacionList extends Component
{
    use WithPagination;

    public $sortColumn = 'calificacion';

    public $sortDirection = 'desc';

    public $calificacion;

    public $alumno_id;

    public $asignatura_id;

    public $modalAbierto = false;

    public function AbrirModal()
    {
        $this->reset();
        $this->modalAbierto = true;
    }

    public function cerrarModal()
    {
        $this->modalAbierto = false;
    }

    public function sortBy($column)
    {
        $this->sortDirection = ($this->sortColumn == $column && $this->sortDirection == 'asc') ? 'desc' : 'asc';
        $this->sortColumn = $column;
    }

    public function guardar()
    {
        $this->validate([
            'calificacion' => 'required|numeric|min:0|max:20',
            'alumno_id' => 'required|exists:alumnos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);
        try {
            DB::beginTransaction();

            Calificacion::create([
                'calificacion' => $this->calificacion,
                'alumno_id' => $this->alumno_id,
                'asignatura_id' => $this->asignatura_id,
            ]);

            DB::commit();
            session()->flash('message', 'Calificación creada con éxito.');
            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error al crear calificación: '.$e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la solicitud.');
        }

        $this->cerrarModal();
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

        $evaluacionesExistentes = Calificacion::all();

        $alumnosDisponibles = Alumno::query();
        if ($this->asignatura_id) {
            $alumnosDisponibles->whereNotIn('id', Calificacion::where('asignatura_id', $this->asignatura_id)->pluck('alumno_id'));
        }

        $asignaturasDisponibles = Asignatura::query();
        if ($this->alumno_id) {
            $asignaturasDisponibles->whereNotIn('id', Calificacion::where('alumno_id', $this->alumno_id)->pluck('asignatura_id'));
        }

        return view('livewire.calificacion-list', [
            'calificaciones' => $query->paginate(10),
            'alumnos' => $this->asignatura_id ? $alumnosDisponibles->get() : Alumno::all(),
            'asignaturas' => $this->alumno_id ? $asignaturasDisponibles->get() : Asignatura::all(),
        ])->layout('components.layouts.app');
    }
}
