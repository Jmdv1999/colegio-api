<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;
    protected $table = 'asignaturas';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'asignatura_id');
    }

    public function profesores()
    {
        return $this->hasMany(Profesor::class, 'asignatura_id');
    }
}
