<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPersonas extends Model
{
    protected $table = 'tm_personas';
    protected $primaryKey = "id";
    protected $fillable = [
        'nombres',
        'apellidos',
        'tipoidentificacion',
        'identificacion',
        'fechanacimiento',
        'nacionalidad',
        'genero',
        'telefono',
        'direccion',
        'email',
        'etnia',
        'parentesco',
        'tipopersona',
        'relacion_id',
        'estado',
        'usuario',
    ];
}
