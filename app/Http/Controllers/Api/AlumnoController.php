<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    public function index()
    {
        return AlumnoResource::collection(Alumno::all());
    }

    public function store(StoreAlumnoRequest $request)
    {
        return new AlumnoResource(Alumno::create($request->validated()));
    }

    public function show(Alumno $alumno)
    {
        return new AlumnoResource($alumno);
    }

    public function update(StoreAlumnoRequest $request, Alumno $alumno)
    {
        $alumno->update($request->validated());

        return new AlumnoResource($alumno);
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return response()->noContent();
    }
}
