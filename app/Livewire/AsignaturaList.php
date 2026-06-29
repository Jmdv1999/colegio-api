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

    public function AbrirModal()
    {
        $this->reset();
        $this->modalAbierto = true;
    }

    public function cerrarModal()
    {
        $this->modalAbierto = false;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            Asignatura::create([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

            DB::commit();
            session()->flash('message', 'Asignatura creada con éxito.');
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
            $asignatura->delete();

            session()->flash('message', 'Asignatura eliminada correctamente.');
        } catch (Exception $e) {
            logger()->error('Error al eliminar asignatura: '.$e->getMessage());
            session()->flash('error', 'No se pudo eliminar el registro, posiblemente tiene información asociada.');
        }
    }
}
