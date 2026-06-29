<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Listado de Asignaturas</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border cursor-pointer" wire:click="sortBy('nombre')">
                    Nombre
                </th>
                <th class="p-2 border cursor-pointer" wire:click="sortBy('descripcion')">
                    Descripción
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaturas as $asignatura)
            <tr>
                <td class="p-2 border">{{ $asignatura->nombre }}</td>
                <td class="p-2 border">{{ $asignatura->descripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($asignaturas->hasPages())
        <div class="mt-4 bg-gray-200 p-2 rounded">
            {{ $asignaturas->links() }}
        </div>
    @endif
</div>