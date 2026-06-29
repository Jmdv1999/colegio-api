<?php

namespace App\Livewire;

use App\Models\Asignatura;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AsignaturaList extends Component
{
    use WithPagination;

    public $nombre;

    public $descripcion;

    public $modalAbierto = false;

    public $sortColumn = 'nombre';

    public $sortDirection = 'asc';
    public $asignatura_id;

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
        $asignatura = Asignatura::findOrFail($id);
        $this->asignatura_id = $asignatura->id;
        $this->nombre = $asignatura->nombre;
        $this->descripcion = $asignatura->descripcion;
        $this->modalAbierto = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:100|unique:asignaturas,nombre,'.($this->asignatura_id ?? 'NULL'),
            'descripcion' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            Asignatura::updateOrCreate([
                'id' => $this->asignatura_id
            ], [
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

            DB::commit();
            session()->flash('message', $this->asignatura_id ? 'Asignatura actualizada con éxito.' : 'Asignatura creada con éxito.');
            $this->reset();
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Error al crear asignatura: '.$e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la solicitud.');
        }
    }

    public function sortBy($column)
    {
        $this->sortDirection = ($this->sortColumn == $column && $this->sortDirection == 'asc') ? 'desc' : 'asc';
        $this->sortColumn = $column;
    }

    public function render()
    {
        return view('livewire.asignatura-list', [
            'asignaturas' => Asignatura::orderBy($this->sortColumn, $this->sortDirection)->paginate(10),
        ])->layout('components.layouts.app');
    }

    public function eliminar($id)
    {
        try {
            $asignatura = Asignatura::findOrFail($id);

            if ($asignatura->calificaciones()->exists()) {
                session()->flash('error', 'No se puede eliminar la asignatura porque tiene calificaciones asociadas.');
                return;
            }

            if ($asignatura->profesores()->exists()) {
                session()->flash('error', 'No se puede eliminar la asignatura porque tiene profesores asociados.');
                return;
            }

            $asignatura->delete();

            session()->flash('message', 'Asignatura eliminada correctamente.');
        } catch (Exception $e) {
            logger()->error('Error al eliminar asignatura: '.$e->getMessage());
            session()->flash('error', 'No se pudo eliminar el registro.');
        }
    }
}
