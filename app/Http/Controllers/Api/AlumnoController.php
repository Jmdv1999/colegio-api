<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumno;

/**
 * @group Alumnos
 *
 * Gestión de alumnos del sistema escolar.
 */
class AlumnoController extends Controller
{
    /**
     * Listar alumnos
     *
     * Obtiene todos los alumnos registrados en el sistema.
     *
     * @responseField id integer ID del alumno.
     * @responseField nombre string Nombre del alumno.
     * @responseField apellido string Apellido del alumno.
     * @responseField cedula string Cédula de identidad del alumno.
     * @responseField nacimiento string Fecha de nacimiento (YYYY-MM-DD).
     * @responseField edad integer Edad calculada del alumno.
     */
    public function index()
    {
        return AlumnoResource::collection(Alumno::all());
    }

    /**
     * Crear alumno
     *
     * Registra un nuevo alumno en el sistema.
     *
     * @bodyParam nombre string required Nombre del alumno. Example: Juan
     * @bodyParam apellido string required Apellido del alumno. Example: Pérez
     * @bodyParam cedula string required Cédula de identidad (solo dígitos, máximo 12). Example: 1234567890
     * @bodyParam nacimiento date required Fecha de nacimiento (formato YYYY-MM-DD, debe ser anterior a hoy). Example: 2010-05-15
     *
     * @responseField id integer ID del alumno creado.
     * @responseField nombre string Nombre del alumno.
     * @responseField apellido string Apellido del alumno.
     * @responseField cedula string Cédula de identidad del alumno.
     * @responseField nacimiento string Fecha de nacimiento (YYYY-MM-DD).
     * @responseField edad integer Edad calculada del alumno.
     */
    public function store(StoreAlumnoRequest $request)
    {
        return new AlumnoResource(Alumno::create($request->validated()));
    }

    /**
     * Obtener alumno
     *
     * Muestra la información de un alumno específico.
     *
     * @urlParam id integer required ID del alumno. Example: 1
     *
     * @responseField id integer ID del alumno.
     * @responseField nombre string Nombre del alumno.
     * @responseField apellido string Apellido del alumno.
     * @responseField cedula string Cédula de identidad del alumno.
     * @responseField nacimiento string Fecha de nacimiento (YYYY-MM-DD).
     * @responseField edad integer Edad calculada del alumno.
     */
    public function show(Alumno $alumno)
    {
        return new AlumnoResource($alumno);
    }

    /**
     * Actualizar alumno
     *
     * Actualiza los datos de un alumno existente.
     *
     * @urlParam id integer required ID del alumno. Example: 1
     *
     * @bodyParam nombre string required Nombre del alumno. Example: Juan
     * @bodyParam apellido string required Apellido del alumno. Example: Pérez
     * @bodyParam cedula string required Cédula de identidad (solo dígitos, máximo 12). Example: 1234567890
     * @bodyParam nacimiento date required Fecha de nacimiento (formato YYYY-MM-DD, debe ser anterior a hoy). Example: 2010-05-15
     *
     * @responseField id integer ID del alumno.
     * @responseField nombre string Nombre del alumno.
     * @responseField apellido string Apellido del alumno.
     * @responseField cedula string Cédula de identidad del alumno.
     * @responseField nacimiento string Fecha de nacimiento (YYYY-MM-DD).
     * @responseField edad integer Edad calculada del alumno.
     */
    public function update(StoreAlumnoRequest $request, Alumno $alumno)
    {
        $alumno->update($request->validated());

        return new AlumnoResource($alumno);
    }

    /**
     * Eliminar alumno
     *
     * Elimina un alumno del sistema.
     *
     * @urlParam id integer required ID del alumno. Example: 1
     *
     * @response 204
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return response()->noContent();
    }
}
