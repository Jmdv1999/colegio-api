<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfesorRequest;
use App\Http\Resources\ProfesorResource;
use App\Models\Profesor;

class ProfesorController extends Controller
{
    public function index()
    {
        return ProfesorResource::collection(Profesor::with('asignatura')->get());
    }

    public function store(StoreProfesorRequest $request)
    {
        return new ProfesorResource(Profesor::create($request->validated()));
    }

    public function show(Profesor $profesor)
    {
        return new ProfesorResource($profesor->load('asignatura'));
    }

    public function update(StoreProfesorRequest $request, Profesor $profesor)
    {
        $profesor->update($request->validated());

        return new ProfesorResource($profesor);
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->delete();

        return response()->noContent();
    }
}
