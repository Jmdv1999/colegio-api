<?php

namespace App\Livewire;

use App\Models\Asignatura;
use App\Models\Profesor;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ProfesorList extends Component
{
    use WithPagination;

    public $sortColumn = 'nombre';

    public $sortDirection = 'asc';

    public $nombre;

    public $apellido;

    public $cedula;

    public $asignatura_id;

    public $profesor_id;

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

    public function editar($id)
    {
        $profesor = Profesor::findOrFail($id);
        $this->profesor_id = $profesor->id;
        $this->nombre = $profesor->nombre;
        $this->apellido = $profesor->apellido;
        $this->cedula = $profesor->cedula;
        $this->asignatura_id = $profesor->asignatura_id;
        $this->modalAbierto = true;
    }

    public function sortBy($column)
    {
        $this->sortDirection = ($this->sortColumn == $column && $this->sortDirection == 'asc') ? 'desc' : 'asc';
        $this->sortColumn = $column;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|regex:/^[0-9]+$/|max:12|unique:profesores,cedula,'.($this->profesor_id ?? 'NULL'),
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);

        try {
            DB::beginTransaction();

            Profesor::updateOrCreate(
                ['id' => $this->profesor_id],
                [
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'cedula' => $this->cedula,
                    'asignatura_id' => $this->asignatura_id,
                ]
            );

            DB::commit();
            session()->flash('message', $this->profesor_id ? 'Profesor actualizado con éxito.' : 'Profesor creado con éxito.');
            $this->reset();
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Error al guardar profesor: '.$e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la solicitud.');
        }

    }

    public function eliminar($id)
    {
        try {
            $profesor = Profesor::findOrFail($id);
            $profesor->delete();

            session()->flash('message', 'Profesor eliminado con éxito.');
        } catch (Exception $e) {
            logger()->error('Error al eliminar profesor: '.$e->getMessage());
            session()->flash('error', 'No se pudo eliminar el registro.');
        }
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
        $asignaturasDisponibles = Asignatura::whereNotIn('id',
            Profesor::where('id', '!=', $this->profesor_id ?? 0)
                ->pluck('asignatura_id')
        )->get();

        return view('livewire.profesor-list', [
            'profesores' => $query->paginate(10),
            'asignaturas' => $asignaturasDisponibles,
        ])->layout('components.layouts.app');
    }
}
