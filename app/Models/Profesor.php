<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    /** @use HasFactory<\Database\Factories\ProfesorFactory> */
    use HasFactory;

    protected $table = 'profesores';
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'asignatura_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }
}
