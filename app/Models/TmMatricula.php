<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmMatricula extends Model
{
    protected $table = 'tm_matriculas';
    protected $primaryKey = "id";
    protected $fillable = [
        'documento',
        'fecha',
        'estudiante_id',
        'nivel_id',
        'modalidad_id',
        'grado_id',
        'periodo_id',
        'curso_id',
        'representante_id',
        'comentario',
        'estado',
        'usuario',
    ];
}
