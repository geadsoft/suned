<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdCalificacionActividades extends Model
{
    //use HasFactory;
    protected $table = 'td_calificacion_actividades';
    protected $primaryKey = "id";
    protected $fillable = [
        'actividad_id',
        'persona_id',
        'nota',
        'estado',
        'usuario'
    ];
}
