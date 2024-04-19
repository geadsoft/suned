<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrFacturasDets extends Model
{
    protected $table = 'tr_facturas_dets';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo',
        'mes',
        'facturacab_id',
        'linea',
        'deudadet_id',
        'codigo',
        'descripcion',
        'unidad',
        'cantidad',
        'precio',
        'descuento',
        'impuesto',
        'total',
        'estado',
        'usuario',
    ]; 

    public function factura(){
        return $this->belongsTo('App\Models\TrFacturasCabs');
    }

}
