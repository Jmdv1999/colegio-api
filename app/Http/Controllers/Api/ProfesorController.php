<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfesorRequest;
use App\Http\Resources\ProfesorResource;
use App\Models\Profesor;

/**
 * @group Profesores
 *
 * Gestión de profesores del sistema escolar.
 */
class ProfesorController extends Controller
{
    /**
     * Listar profesores
     *
     * Obtiene todos los profesores registrados en el sistema.
     *
     * @responseField id integer ID del profesor.
     * @responseField nombre string Nombre del profesor.
     * @responseField apellido string Apellido del profesor.
     * @responseField cedula string Cédula de identidad del profesor.
     * @responseField asignatura object Asignatura que imparte el profesor.
     */
    public function index()
    {
        return ProfesorResource::collection(Profesor::with('asignatura')->get());
    }

    /**
     * Crear profesor
     *
     * Registra un nuevo profesor en el sistema.
     *
     * @bodyParam nombre string required Nombre del profesor. Example: Carlos
     * @bodyParam apellido string required Apellido del profesor. Example: Mendoza
     * @bodyParam cedula string required Cédula de identidad (solo dígitos, máximo 12). Example: 9876543210
     * @bodyParam asignatura_id integer required ID de la asignatura que imparte. Example: 1
     *
     * @responseField id integer ID del profesor creado.
     * @responseField nombre string Nombre del profesor.
     * @responseField apellido string Apellido del profesor.
     * @responseField cedula string Cédula de identidad del profesor.
     * @responseField asignatura object Asignatura que imparte el profesor.
     */
    public function store(StoreProfesorRequest $request)
    {
        return new ProfesorResource(Profesor::create($request->validated()));
    }

    /**
     * Obtener profesor
     *
     * Muestra la información de un profesor específico.
     *
     * @urlParam id integer required ID del profesor. Example: 1
     *
     * @responseField id integer ID del profesor.
     * @responseField nombre string Nombre del profesor.
     * @responseField apellido string Apellido del profesor.
     * @responseField cedula string Cédula de identidad del profesor.
     * @responseField asignatura object Asignatura que imparte el profesor.
     */
    public function show(Profesor $profesor)
    {
        return new ProfesorResource($profesor->load('asignatura'));
    }

    /**
     * Actualizar profesor
     *
     * Actualiza los datos de un profesor existente.
     *
     * @urlParam id integer required ID del profesor. Example: 1
     *
     * @bodyParam nombre string required Nombre del profesor. Example: Carlos
     * @bodyParam apellido string required Apellido del profesor. Example: Mendoza
     * @bodyParam cedula string required Cédula de identidad (solo dígitos, máximo 12). Example: 9876543210
     * @bodyParam asignatura_id integer required ID de la asignatura que imparte. Example: 1
     *
     * @responseField id integer ID del profesor.
     * @responseField nombre string Nombre del profesor.
     * @responseField apellido string Apellido del profesor.
     * @responseField cedula string Cédula de identidad del profesor.
     * @responseField asignatura object Asignatura que imparte el profesor.
     */
    public function update(StoreProfesorRequest $request, Profesor $profesor)
    {
        $profesor->update($request->validated());

        return new ProfesorResource($profesor);
    }

    /**
     * Eliminar profesor
     *
     * Elimina un profesor del sistema.
     *
     * @urlParam id integer required ID del profesor. Example: 1
     *
     * @response 204
     */
    public function destroy(Profesor $profesor)
    {
        $profesor->delete();

        return response()->noContent();
    }
}
