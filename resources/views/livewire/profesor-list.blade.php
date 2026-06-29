<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Listado de Profesores</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Nombre</th>
                <th class="p-2 border">Cédula</th>
                <th class="p-2 border">Asignatura</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profesores as $profesor)
            <tr>
                <td class="p-2 border">{{ $profesor->nombre }} {{ $profesor->apellido }}</td>
                <td class="p-2 border">{{ $profesor->cedula }}</td>
                <td class="p-2 border">{{ $profesor->asignatura->nombre }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>