<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4 p-2">
        <h2 class="text-xl font-bold">
            Listado de Calificaciones
        </h2>
        <button wire:click="AbrirModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
            Nueva Calificación
        </button>
    </div>
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-2 mb-4">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-2 mb-4">{{ session('error') }}</div>
    @endif
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border cursor-pointer" wire:click="sortBy('alumno.nombre')">
                    Estudiante
                </th>
                <th class="p-2 border cursor-pointer" wire:click="sortBy('asignatura.nombre')">
                    Asignatura
                </th>
                <th class="p-2 border cursor-pointer" wire:click="sortBy('calificacion')">
                    Calificación
                </th>
                <th class="p-2 border"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calificaciones as $calificacion)
                <tr>
                    <td class="p-2 border">{{ $calificacion->alumno->nombre }} {{ $calificacion->alumno->apellido }}
                    </td>
                    <td class="p-2 border">{{ $calificacion->asignatura->nombre }}</td>
                    <td class="p-2 border">{{ $calificacion->calificacion }}</td>
                    <td class="p-2 border">
                        <button wire:click="eliminar({{ $calificacion->id }})"
                            wire:confirm="¿Estás completamente seguro? Esta acción borrará la calificación del estudiante '{{ $calificacion->alumno->nombre }}' permanentemente."
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Eliminar
                        </button>
                        <button wire:click="editar({{ $calificacion->id }})"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Editar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($modalAbierto)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">{{ $asignatura_id ? 'Editar Asignatura' : 'Crear Asignatura' }}</h2>

                <input type="number" wire:model="calificacion" placeholder="Calificación"
                    class="border p-2 w-full mb-2">
                @error('calificacion')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <select wire:model.live="alumno_id" class="border p-2 w-full mb-2">
                    <option value="">Seleccionar Alumno</option>
                    @foreach ($alumnos as $alumno)
                        <option value="{{ $alumno->id }}">{{ $alumno->nombre }} {{ $alumno->apellido }}</option>
                    @endforeach
                </select>
                @error('alumno_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <select wire:model.live="asignatura_id" class="border p-2 w-full mb-2">
                    <option value="">Seleccionar Asignatura</option>
                    @foreach ($asignaturas as $asignatura)
                        <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }}</option>
                    @endforeach
                </select>
                @error('asignatura_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror


                <div class="mt-4 flex justify-end">
                    <button wire:click="cerrarModal()" class="mr-2">Cancelar</button>
                    <button wire:click="guardar()" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </div>
        </div>
    @endif
    @if ($calificaciones->hasPages())
        <div class="mt-4 bg-gray-200 p-2 rounded">
            {{ $calificaciones->links() }}
        </div>
    @endif
</div>
