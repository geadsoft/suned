<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPeriodosLectivos extends Model
{
    protected $table = 'tm_periodos_lectivos';
    protected $primaryKey = "id";
    protected $fillable = [
        'descripcion',
        'sede_id',
        'periodo',
        'rector_id',
        'secretaria_id',
        'coordinador_id',
        'mes_pension',
        'evaluacion',
        'evaluacion_formativa',
        'evaluacion_sumativa',
        'aperturado',
        'estado',
        'usuario',
    ];
}
