<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalificacionRequest;
use App\Http\Resources\CalificacionResource;
use App\Models\Calificacion;

class CalificacionController extends Controller
{
    public function index()
    {
        return CalificacionResource::collection(Calificacion::with(['alumno', 'asignatura'])->get());
    }

    public function store(StoreCalificacionRequest $request)
    {
        return new CalificacionResource(Calificacion::create($request->validated()));
    }

    public function show(Calificacion $calificacion)
    {
        return new CalificacionResource($calificacion->load(['alumno', 'asignatura']));
    }

    public function update(StoreCalificacionRequest $request, Calificacion $calificacion)
    {
        $calificacion->update($request->validated());

        return new CalificacionResource($calificacion);
    }

    public function destroy(Calificacion $calificacion)
    {
        $calificacion->delete();

        return response()->noContent();
    }
}
