<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdTitulosActas extends Model
{
    protected $table = 'td_titulos_actas';
    protected $primaryKey = "id";
    protected $fillable = [
        'fecha',
        'periodo_id',
        'estudiante_id',
        'titulo',
        'acta',
        'comentario',
        'usuario'
    ];

}
