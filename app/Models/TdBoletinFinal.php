<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdBoletinFinal extends Model
{
    //use HasFactory;
    protected $table = 'td_boletin_finals';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'modalidad_id',
        'curso_id',
        'persona_id',
        'asignatura_id',
        '1T_notaparcial',
        '1T_nota70',
        '1T_evaluacion',
        '1T_nota30',
        '1T_notatrimestre',
        '2T_notaparcial',
        '2T_nota70',
        '2T_evaluacion',
        '2T_nota30',
        '2T_notatrimestre',
        '3T_notaparcial',
        '3T_nota70',
        '3T_evaluacion',
        '3T_nota30',
        '3T_notatrimestre',
        'promedio_anual',
        'supletorio',
        'promedio_final',
        'promedio_cualitativo',
        'promocion'

    ];
}
