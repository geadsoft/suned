<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrFacturasCabs extends Model
{
    protected $table = 'tr_facturas_cabs';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo',
        'mes',
        'tipo',
        'fecha',
        'establecimiento',
        'puntoemision',
        'documento',
        'persona_id',
        'plazo',
        'tipo_plazo',
        'subtotal_grabado',
        'subtotal_nograbado',
        'subtotal_nosujeto',
        'subtotal_excento',
        'descuento',
        'subtotal',
        'impuesto',
        'neto',
        'estado',
        'docelectronico',
        'usuario',
    ];   
}
