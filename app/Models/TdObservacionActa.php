<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdObservacionActa extends Model
{
    //use HasFactory;
    protected $table = 'td_observacion_actas';
    protected $primaryKey = "id";
    protected $fillable = [
        'curso_id',
        'termino',
        'bloque',
        'persona_id',
        'comentario',
        'estado',
        'usuario',
    ];
}
