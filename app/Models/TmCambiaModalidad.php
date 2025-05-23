<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmCambiaModalidad extends Model
{
    protected $table = 'tm_cambia_modalidad';
    protected $primaryKey = "id";
    protected $fillable = [
        'persona_id',
        'matricula_id',
        'modalidad_id',
        'grado_id',
        'curso_id',
        'modalidad',
        'curso',

    ];

}
