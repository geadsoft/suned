<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmSistemaEducativos extends Model
{
    protected $table = 'tm_sistema_educativos';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'modalidad_id',
        'evaluacion',
        'evaluacion_formativa',
        'evaluacion_sumativa',
        'usuario',
    ];
}
