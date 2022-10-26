<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmMatriculaEstudiante extends Model
{
    protected $table = 'tm_matriculas';
    protected $primaryKey = "id";
    protected $fillable = [
        'fecha',
        'persona_id',
        'periodo_id',
        'nivel_id',
        'modalidad_id',
        'grado_id',
        'seccion_id',
        'estado',
        'usuario',
    ];
}
