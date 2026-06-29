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

    public $alumno_id;

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
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|regex:/^[0-9]+$/|max:12|unique:alumnos,cedula,'.($this->alumno_id ?? 'NULL'),
            'nacimiento' => 'required|date|before:today',
        ]);

        try {
            DB::beginTransaction();

            Alumno::updateOrCreate(
                ['id' => $this->alumno_id],
                [
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'cedula' => $this->cedula,
                    'nacimiento' => $this->nacimiento,
                ]
            );
            DB::commit();
            session()->flash('message', $this->alumno_id ? 'Alumno actualizado.' : 'Alumno creado.');
            $this->reset();
            $this->modalAbierto = false;
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Error al crear alumno: '.$e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la solicitud.');
        }
    }

    public function eliminar($id)
    {
        try {
            $alumno = Alumno::findOrFail($id);

            if ($alumno->calificaciones()->exists()) {
                session()->flash('error', 'No se puede eliminar el alumno porque tiene calificaciones asociadas.');
                return;
            }

            $alumno->delete();

            session()->flash('message', 'Alumno eliminado correctamente.');
        } catch (Exception $e) {
            logger()->error('Error al eliminar alumno: '.$e->getMessage());
            session()->flash('error', 'No se pudo eliminar el registro.');
        }
    }

    public function editar($id)
    {
        $alumno = Alumno::findOrFail($id);
        $this->alumno_id = $alumno->id;
        $this->nombre = $alumno->nombre;
        $this->apellido = $alumno->apellido;
        $this->cedula = $alumno->cedula;
        $this->nacimiento = $alumno->nacimiento;

        $this->modalAbierto = true;
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
