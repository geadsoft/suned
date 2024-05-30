<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrInventarioFpago extends Model
{
    protected $table = 'tr_inventario_fpagos';
    protected $primaryKey = "id";
    protected $fillable = [
        'inventariocab_id',
        'linea',
        'tipopago',
        'valor',
        'estado',
        'usuario',
    ];

}
