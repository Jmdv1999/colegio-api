<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAsignaturaRequest;
use App\Http\Resources\AsignaturaResource;
use App\Models\Asignatura;

class AsignaturaController extends Controller
{
    public function index()
    {
        return AsignaturaResource::collection(Asignatura::all());
    }

    public function store(StoreAsignaturaRequest $request)
    {
        return new AsignaturaResource(Asignatura::create($request->validated()));
    }

    public function show(Asignatura $asignatura)
    {
        return new AsignaturaResource($asignatura);
    }

    public function update(StoreAsignaturaRequest $request, Asignatura $asignatura)
    {
        $asignatura->update($request->validated());

        return new AsignaturaResource($asignatura);
    }

    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();

        return response()->noContent();
    }
}
