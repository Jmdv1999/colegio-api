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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:500',
            'cedula' => 'required|numeric|unique:profesores|max_digits:12',
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);

        try {
            DB::beginTransaction();

            Profesor::create([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'cedula' => $this->cedula,
                'asignatura_id' => $this->asignatura_id,
            ]);

            DB::commit();
            session()->flash('message', 'Profesor creado con éxito.');
            $this->reset();
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Error al crear profesor: '.$e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la solicitud.');
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

        return view('livewire.profesor-list', [
            'profesores' => $query->paginate(10),
            'asignaturas' => Asignatura::whereNotIn('id', Profesor::select('asignatura_id'))->get(),
        ])->layout('components.layouts.app');
    }
}
