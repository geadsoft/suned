<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmDomicilioEstudiantes extends Model
{
    protected $table = 'tm_domicilio_estudiantes';
    protected $primaryKey = "id";
    protected $fillable = [
        'estudiante_id',
        'direccion',
        'domingo',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
        'usuario',
    ];

}
