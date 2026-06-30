<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalificacionRequest;
use App\Http\Requests\UpdateCalificacionRequest;
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
        $calificacion = Calificacion::where([
            'alumno_id' => $request->alumno_id,
            'asignatura_id' => $request->asignatura_id,
        ])->exists();

        if ($calificacion) {
            return response()->json([
                'message' => 'Ya existe una calificación para este alumno en esta asignatura.',
            ], 409);
        }

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
    public function show(string $id)
    {
        $calificacion = Calificacion::with(['alumno', 'asignatura'])->find($id);

        if (!$calificacion) {
            return response()->json([
                'message' => "Calificación con ID $id no encontrada",
            ], 404);
        }

        return new CalificacionResource($calificacion);
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
    public function update(UpdateCalificacionRequest $request, string $id)
    {
        $calificacion = Calificacion::findOrFail($id);

        $alumnoId = $request->input('alumno_id', $calificacion->alumno_id);
        $asignaturaId = $request->input('asignatura_id', $calificacion->asignatura_id);

        $existe = Calificacion::where([
            'alumno_id' => $alumnoId,
            'asignatura_id' => $asignaturaId,
        ])->where('id', '!=', $id)->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Ya existe una calificación para este alumno en esta asignatura.',
            ], 409);
        }

        $calificacion->update($request->validated());

        return new CalificacionResource($calificacion->load(['alumno', 'asignatura']));
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
    public function destroy(string $id)
    {
        $calificacion = Calificacion::find($id);

        if (!$calificacion) {
            return response()->json([
                'message' => "Calificación con ID $id no encontrada",
            ], 404);
        }

        $calificacion->delete();

        return response()->noContent();
    }
}
