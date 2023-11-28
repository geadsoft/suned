<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrRegistrocasCab extends Model
{
    protected $table = 'tr_registrocas_cab';
    protected $primaryKey = "id";
    protected $fillable = [
        'fecha',
        'periodo_id',
        'grupo_id',
        'grado_id',
        'curso_id',
        'referencia',
        'usuario',
    ];
}
