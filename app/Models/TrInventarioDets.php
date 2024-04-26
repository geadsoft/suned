<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrInventarioDets extends Model
{
    protected $table = 'tr_inventario_dets';
    protected $primaryKey = "id";
    protected $fillable = [
        'inventariocab_id',
        'periodo',
        'mes',
        'tipo',
        'documento',
        'fecha',
        'movimiento',
        'linea',
        'producto_id',
        'cantidad',
        'unidad',
        'precio',
        'total',
        'estado',
        'usuario',
    ];

    public function producto(){
        return $this->belongsTo('App\Models\TmProductos');
    }
}
