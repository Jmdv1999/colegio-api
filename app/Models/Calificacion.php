<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    /** @use HasFactory<\Database\Factories\CalificacionFactory> */
    use HasFactory;
    protected $table = 'calificaciones';

    protected $fillable = [
        'alumno_id',
        'asignatura_id',
        'calificacion',
    ]; 
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }
}
