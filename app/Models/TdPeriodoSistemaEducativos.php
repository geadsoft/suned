<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdPeriodoSistemaEducativos extends Model
{
    protected $table = 'td_periodo_sistema_educativos';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'tipo',
        'codigo',
        'evaluacion',
        'descripcion',
        'nota',
        'modalidad_id',
        'hora_ini',
        'hora_fin',
        'usuario',
    ];

}
