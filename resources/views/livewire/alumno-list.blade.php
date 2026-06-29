<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Listado de Alumnos</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Nombre</th>
                <th class="p-2 border">Cédula</th>
                <th class="p-2 border">Edad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
            <tr>
                <td class="p-2 border">{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                <td class="p-2 border">{{ $alumno->cedula }}</td>
                <td class="p-2 border">{{ $alumno->nacimiento }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>