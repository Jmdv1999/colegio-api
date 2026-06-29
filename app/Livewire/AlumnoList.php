<?php

namespace App\Livewire;

use App\Models\Alumno;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AlumnoList extends Component
{
    use WithPagination;

    public $sortColumn = 'nombre';

    public $sortDirection = 'asc';

    public $nombre;

    public $apellido;

    public $cedula;

    public $nacimiento;

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
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|unique:alumnos,cedula|numeric|max_digits:12',
            'nacimiento' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            Alumno::create([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'cedula' => $this->cedula,
                'nacimiento' => $this->nacimiento,
            ]);

            DB::commit();
            session()->flash('message', 'Alumno creado con éxito.');
            $this->reset();
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Error al crear alumno: '.$e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la solicitud.');
        }
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
