<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdActividadesEntregas extends Model
{
    protected $table = 'td_actividades_entregas';
    protected $primaryKey = "id";
    protected $fillable = [
        'fecha',
        'actividad_id',
        'persona_id',
        'comentario',
        'nota',
        'usuario',
    ];

}
