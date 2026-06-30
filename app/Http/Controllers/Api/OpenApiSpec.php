<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *   title="API Colegio",
 *   version="1.0.0",
 *   description="Documentación de la API del Sistema Escolar"
 * )
 * @OA\Server(
 *   url="http://127.0.0.1:8000",
 *   description="Servidor Local"
 * )
 *
 * @OA\Schema(
 *   schema="AlumnoResource",
 *   type="object",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="nombre", type="string", example="Juan"),
 *   @OA\Property(property="apellido", type="string", example="Pérez"),
 *   @OA\Property(property="cedula", type="string", example="1234567890"),
 *   @OA\Property(property="nacimiento", type="string", format="date", example="2000-01-15"),
 *   @OA\Property(property="edad", type="integer", example=26)
 * )
 *
 * @OA\Schema(
 *   schema="StoreAlumnoRequest",
 *   type="object",
 *   required={"nombre", "apellido", "cedula", "nacimiento"},
 *   @OA\Property(property="nombre", type="string", maxLength=100, example="Juan"),
 *   @OA\Property(property="apellido", type="string", maxLength=100, example="Pérez"),
 *   @OA\Property(property="cedula", type="string", maxLength=12, example="1234567890"),
 *   @OA\Property(property="nacimiento", type="string", format="date", example="2000-01-15")
 * )
 */
class OpenApiSpec {}
