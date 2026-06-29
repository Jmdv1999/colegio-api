<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAsignaturaRequest;
use App\Http\Requests\UpdateAsignaturaRequest;
use App\Http\Resources\AsignaturaResource;
use App\Models\Asignatura;

/**
 * @group Asignaturas
 *
 * Gestión de asignaturas o materias del sistema escolar.
 */
class AsignaturaController extends Controller
{
    /**
     * Listar asignaturas
     *
     * Obtiene todas las asignaturas registradas en el sistema.
     *
     * @responseField id integer ID de la asignatura.
     * @responseField nombre string Nombre de la asignatura.
     * @responseField descripcion string Descripción de la asignatura.
     */
    public function index()
    {
        return AsignaturaResource::collection(Asignatura::all());
    }

    /**
     * Crear asignatura
     *
     * Registra una nueva asignatura en el sistema.
     *
     * @bodyParam nombre string required Nombre de la asignatura. Example: Matemáticas
     * @bodyParam descripcion string required Descripción de la asignatura. Example: Curso de álgebra y geometría
     *
     * @responseField id integer ID de la asignatura creada.
     * @responseField nombre string Nombre de la asignatura.
     * @responseField descripcion string Descripción de la asignatura.
     */
    public function store(StoreAsignaturaRequest $request)
    {
        return new AsignaturaResource(Asignatura::create($request->validated()));
    }

    /**
     * Obtener asignatura
     *
     * Muestra la información de una asignatura específica.
     *
     * @urlParam id integer required ID de la asignatura. Example: 1
     *
     * @responseField id integer ID de la asignatura.
     * @responseField nombre string Nombre de la asignatura.
     * @responseField descripcion string Descripción de la asignatura.
     */
    public function show(string $id)
    {
        $asignatura = Asignatura::find($id);

        if (!$asignatura) {
            return response()->json([
                'message' => "Asignatura con ID $id no encontrada",
            ], 404);
        }

        return new AsignaturaResource($asignatura);
    }

    /**
     * Actualizar asignatura
     *
     * Actualiza los datos de una asignatura existente.
     *
     * @urlParam id integer required ID de la asignatura. Example: 1
     *
     * @bodyParam nombre string required Nombre de la asignatura. Example: Matemáticas
     * @bodyParam descripcion string required Descripción de la asignatura. Example: Curso de álgebra y geometría
     *
     * @responseField id integer ID de la asignatura.
     * @responseField nombre string Nombre de la asignatura.
     * @responseField descripcion string Descripción de la asignatura.
     */
    public function update(UpdateAsignaturaRequest $request, string $id)
    {
        $asignatura = Asignatura::findOrFail($id);

        $asignatura->update($request->validated());

        return new AsignaturaResource($asignatura);
    }

    /**
     * Eliminar asignatura
     *
     * Elimina una asignatura del sistema.
     *
     * @urlParam id integer required ID de la asignatura. Example: 1
     *
     * @response 204
     */
    public function destroy(string $id)
    {
        $asignatura = Asignatura::find($id);

        if (!$asignatura) {
            return response()->json([
                'message' => "Asignatura con ID $id no encontrada",
            ], 404);
        }

        if ($asignatura->calificaciones()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar la asignatura porque tiene calificaciones asociadas.',
            ], 409);
        }

        if ($asignatura->profesores()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar la asignatura porque tiene profesores asociados.',
            ], 409);
        }

        $asignatura->delete();

        return response()->noContent();
    }
}
