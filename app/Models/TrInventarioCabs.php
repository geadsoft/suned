<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrInventarioCabs extends Model
{
    protected $table = 'tr_inventario_cabs';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo',
        'mes',
        'tipo',
        'documento',
        'fecha',
        'movimiento',
        'referencia',
        'estudiante_id',
        'tipopago',
        'observacion',
        'neto',
        'estado',
        'usuario',
    ];

}
