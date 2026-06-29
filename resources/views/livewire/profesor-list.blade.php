<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4 p-2">
        <h2 class="text-xl font-bold">
            Listado de Profesores
        </h2>
        <button wire:click="AbrirModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
            Nuevo Profesor
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
                <th class="p-2 border cursor-pointer" wire:click="sortBy('nombre')">
                    Nombre
                </th>
                <th class="p-2 border cursor-pointer" wire:click="sortBy('cedula')">
                    Cédula
                </th>
                <th class="p-2 border cursor-pointer" wire:click="sortBy('asignatura.nombre')">
                    Asignatura
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($profesores as $profesor)
                <tr>
                    <td class="p-2 border">{{ $profesor->nombre }} {{ $profesor->apellido }}</td>
                    <td class="p-2 border">{{ $profesor->cedula }}</td>
                    <td class="p-2 border">{{ $profesor->asignatura->nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($profesores->hasPages())
        <div class="mt-4 bg-gray-200 p-2 rounded">
            {{ $profesores->links() }}
        </div>
    @endif
    @if ($modalAbierto)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Crear Profesor</h2>

                <input type="text" wire:model="nombre" placeholder="Nombre" class="border p-2 w-full mb-2">
                @error('nombre')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="apellido" placeholder="Apellido" class="border p-2 w-full mb-2">
                @error('apellido')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="cedula" placeholder="Cédula" class="border p-2 w-full mb-2">
                @error('cedula')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <select wire:model="asignatura_id" class="border p-2 w-full mb-2">
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
</div>
