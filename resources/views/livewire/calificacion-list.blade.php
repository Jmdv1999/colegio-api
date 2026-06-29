<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Listado de Calificaciones</h2>
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
            </tr>
        </thead>
        <tbody>
            @foreach($calificaciones as $calificacion)
            <tr>
                <td class="p-2 border">{{ $calificacion->alumno->nombre }} {{ $calificacion->alumno->apellido }}</td>
                <td class="p-2 border">{{ $calificacion->asignatura->nombre }}</td>
                <td class="p-2 border">{{ $calificacion->calificacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($calificaciones->hasPages())
        <div class="mt-4 bg-gray-200 p-2 rounded">
            {{ $calificaciones->links() }}
        </div>
    @endif
</div>