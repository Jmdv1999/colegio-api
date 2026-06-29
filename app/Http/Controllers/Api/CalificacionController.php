<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalificacionRequest;
use App\Http\Resources\CalificacionResource;
use App\Models\Calificacion;

/**
 * @group Calificaciones
 *
 * Gestión de calificaciones de los alumnos en las distintas asignaturas.
 */
class CalificacionController extends Controller
{
    /**
     * Listar calificaciones
     *
     * Obtiene todas las calificaciones registradas en el sistema.
     *
     * @responseField id integer ID de la calificación.
     * @responseField calificacion number Calificación obtenida (0-20).
     * @responseField alumno object Datos del alumno.
     * @responseField asignatura object Datos de la asignatura.
     */
    public function index()
    {
        return CalificacionResource::collection(Calificacion::with(['alumno', 'asignatura'])->get());
    }

    /**
     * Crear calificación
     *
     * Registra una nueva calificación en el sistema.
     *
     * @bodyParam alumno_id integer required ID del alumno. Example: 1
     * @bodyParam asignatura_id integer required ID de la asignatura. Example: 1
     * @bodyParam calificacion number required Calificación obtenida (0-20). Example: 18
     *
     * @responseField id integer ID de la calificación creada.
     * @responseField calificacion number Calificación obtenida (0-20).
     * @responseField alumno object Datos del alumno.
     * @responseField asignatura object Datos de la asignatura.
     */
    public function store(StoreCalificacionRequest $request)
    {
        return new CalificacionResource(Calificacion::create($request->validated()));
    }

    /**
     * Obtener calificación
     *
     * Muestra la información de una calificación específica.
     *
     * @urlParam id integer required ID de la calificación. Example: 1
     *
     * @responseField id integer ID de la calificación.
     * @responseField calificacion number Calificación obtenida (0-20).
     * @responseField alumno object Datos del alumno.
     * @responseField asignatura object Datos de la asignatura.
     */
    public function show(Calificacion $calificacion)
    {
        return new CalificacionResource($calificacion->load(['alumno', 'asignatura']));
    }

    /**
     * Actualizar calificación
     *
     * Actualiza los datos de una calificación existente.
     *
     * @urlParam id integer required ID de la calificación. Example: 1
     *
     * @bodyParam alumno_id integer required ID del alumno. Example: 1
     * @bodyParam asignatura_id integer required ID de la asignatura. Example: 1
     * @bodyParam calificacion number required Calificación obtenida (0-20). Example: 18
     *
     * @responseField id integer ID de la calificación.
     * @responseField calificacion number Calificación obtenida (0-20).
     * @responseField alumno object Datos del alumno.
     * @responseField asignatura object Datos de la asignatura.
     */
    public function update(StoreCalificacionRequest $request, Calificacion $calificacion)
    {
        $calificacion->update($request->validated());

        return new CalificacionResource($calificacion);
    }

    /**
     * Eliminar calificación
     *
     * Elimina una calificación del sistema.
     *
     * @urlParam id integer required ID de la calificación. Example: 1
     *
     * @response 204
     */
    public function destroy(Calificacion $calificacion)
    {
        $calificacion->delete();

        return response()->noContent();
    }
}
