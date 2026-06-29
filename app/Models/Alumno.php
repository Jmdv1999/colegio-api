<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Carbon\Carbon;

class Alumno extends Model
{
    /** @use HasFactory<\Database\Factories\AlumnoFactory> */
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'nacimiento',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['edad'];

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'alumno_id');
    }

    protected function edad():Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->nacimiento)->age,
        );
    }
    
}
