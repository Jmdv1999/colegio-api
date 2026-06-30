<?php

namespace App\Livewire;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Calificacion;
use Exception;
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

    public $calificacion_id;

    public $modalAbierto = false;

    public function AbrirModal()
    {
        $this->reset();
        $this->modalAbierto = true;
    }

    public function editar($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $this->calificacion_id = $calificacion->id;
        $this->calificacion = $calificacion->calificacion;
        $this->alumno_id = $calificacion->alumno_id;
        $this->asignatura_id = $calificacion->asignatura_id;
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
            'alumno_id' => [
                'required',
                'exists:alumnos,id',
            ],
            'asignatura_id' => [
                'required',
                'exists:asignaturas,id',
            ],
        ]);

        $exists = Calificacion::where('alumno_id', $this->alumno_id)
            ->where('asignatura_id', $this->asignatura_id)
            ->where('id', '!=', $this->calificacion_id ?? 0)
            ->exists();

        if ($exists) {
            $this->addError('alumno_id', 'Ya existe una calificación para este alumno en esta asignatura.');
            return;
        }

        try {
            DB::beginTransaction();

            Calificacion::updateOrCreate(
                ['id' => $this->calificacion_id],
                [
                    'calificacion' => $this->calificacion,
                    'alumno_id' => $this->alumno_id,
                    'asignatura_id' => $this->asignatura_id,
                ]);

            DB::commit();
            session()->flash('message', $this->calificacion_id ? 'Calificación actualizada con éxito.' : 'Calificación creada con éxito.');
            $this->reset();
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Error al crear calificación: '.$e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la solicitud.');
        }

        $this->cerrarModal();
    }

    public function eliminar($id)
    {
        try {
            $calificacion = Calificacion::findOrFail($id);
            $calificacion->delete();

            session()->flash('message', 'Calificación eliminada con éxito.');
        } catch (Exception $e) {
            logger()->error('Error al eliminar calificación: '.$e->getMessage());
            session()->flash('error', 'No se pudo eliminar el registro.');
        }
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

        $alumnosDisponibles = Alumno::query();
        if ($this->asignatura_id) {
            $alumnosDisponibles->whereNotIn('id',
                Calificacion::where('asignatura_id', $this->asignatura_id)
                    ->where('id', '!=', $this->calificacion_id ?? 0)
                    ->pluck('alumno_id')
            );
        }

        $asignaturasDisponibles = Asignatura::query();
        if ($this->alumno_id) {
            $asignaturasDisponibles->whereNotIn('id',
                Calificacion::where('alumno_id', $this->alumno_id)
                    ->where('id', '!=', $this->calificacion_id ?? 0)
                    ->pluck('asignatura_id')
            );
        }

        return view('livewire.calificacion-list', [
            'calificaciones' => $query->paginate(10),
            'alumnos' => $this->asignatura_id ? $alumnosDisponibles->get() : Alumno::all(),
            'asignaturas' => $this->alumno_id ? $asignaturasDisponibles->get() : Asignatura::all(),
        ])->layout('components.layouts.app');
    }
}
