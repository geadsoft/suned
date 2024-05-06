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
        'autorizacion',
        'persona_id',
        'periodo_id',
        'estudiante_id',
        'formapago',
        'dias',
        'plazo',
        'subtotal_grabado',
        'subtotal_nograbado',
        'subtotal_nosujeto',
        'subtotal_excento',
        'descuento',
        'subtotal',
        'impuesto',
        'neto',
        'docaplica',
        'fecha_docaplica',
        'motivo',
        'estado',
        'docelectronico',
        'usuario',
    ];   

    public function persona(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }
}
