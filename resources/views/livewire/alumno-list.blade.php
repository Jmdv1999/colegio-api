<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Listado de Alumnos</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                
                <th class="cursor-pointer p-2 border " wire:click="sortBy('nombre')">Nombre</th>
                <th class="cursor-pointer p-2 border" wire:click="sortBy('cedula')">Cédula</th>
                <th class="cursor-pointer p-2 border" wire:click="sortBy('edad')">Edad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
                <tr>
                    <td class="p-2 border">{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                    <td class="p-2 border">{{ $alumno->cedula }}</td>
                    <td class="p-2 border">{{ $alumno->edad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($alumnos->hasPages())
        <div class="mt-4 bg-gray-200 p-2 rounded">
            {{ $alumnos->links() }}
        </div>
    @endif
</div>
