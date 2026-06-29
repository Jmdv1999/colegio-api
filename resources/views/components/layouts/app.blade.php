<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegio API Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex gap-4">
            <a href="/alumnos" class="hover:underline">Alumnos</a>
            <a href="/asignaturas" class="hover:underline">Asignaturas</a>
            <a href="/profesores" class="hover:underline">Profesores</a>
            <a href="/calificaciones" class="hover:underline">Calificaciones</a>
        </div>
    </nav>

    <main class="container mx-auto p-6">
        {{ $slot }}
    </main>

</body>
</html>