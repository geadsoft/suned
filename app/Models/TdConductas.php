<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdConductas extends Model
{
    protected $table = 'td_conductas';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'modalidad_id',
        'termino',
        'curso_id',
        'persona_id',
        'evaluacion',
        'usuario',
    ];
}
