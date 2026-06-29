<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4 p-2">
        <h2 class="text-xl font-bold">
            Listado de Alumnos
        </h2>
        <button wire:click="AbrirModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
            Nuevo Alumno
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-2 mb-4">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-2 mb-4">{{ session('error') }}</div>
    @endif


    <table class="w-full border-collapse mt-2">
        <thead>
            <tr class="bg-gray-200">

                <th class="cursor-pointer p-2 border " wire:click="sortBy('nombre')">Nombre</th>
                <th class="cursor-pointer p-2 border" wire:click="sortBy('cedula')">Cédula</th>
                <th class="cursor-pointer p-2 border" wire:click="sortBy('nacimiento')">Nacimiento</th>
                <th class="cursor-pointer p-2 border" wire:click="sortBy('edad')">Edad</th>
                <th class="p-2 border"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
                <tr>
                    <td class="p-2 border">{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                    <td class="p-2 border">{{ $alumno->cedula }}</td>
                    <td class="p-2 border">{{ $alumno->nacimiento }}</td>
                    <td class="p-2 border">{{ $alumno->edad }}</td>
                    <td class="p-2 border">
                        <button wire:click="eliminar({{ $alumno->id }})"
                            wire:confirm="¿Estás completamente seguro? Esta acción borrará al alumno '{{ $alumno->nombre }}' permanentemente."
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($alumnos->hasPages())
        <div class="mt-4 bg-gray-200 p-2 rounded">
            {{ $alumnos->links() }}
        </div>
    @endif
    @if ($modalAbierto)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Crear Alumno</h2>

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
                <input type="date" wire:model="nacimiento" placeholder="Nacimiento" class="border p-2 w-full mb-2">
                @error('nacimiento')
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
