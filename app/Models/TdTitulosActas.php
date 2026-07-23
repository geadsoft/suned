<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdTitulosActas extends Model
{
    protected $table = 'td_titulos_actas';
    protected $primaryKey = "id";
    protected $fillable = [
        'matricula_id',
        'acta_retirada',
        'titulo_retirado',
        'fecha_acta',
        'entregado_acta_por',
        'recibido_acta_por',
        'fecha_titulo',
        'entregado_titulo_por',
        'recibido_titulo_por',
        'comentario',
        'archivo',
        'drive_id',
        'usuario'
    ];

}
