<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
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

    protected function edad(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->nacimiento)->age,
        );
    }
}
