<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrDeudasDets extends Model
{
    protected $table = 'tr_deudas_dets';
    protected $primaryKey = "id";
    protected $fillable = [
        'deudacab_id',
        'cobro_id',
        'fecha',
        'detalle',
        'tipo',
        'referencia',
        'tipovalor',
        'valor',
        'estado',
        'usuario',
    ];

    public function deudacab(){
        return $this->belongsTo('App\Models\TrDeudasCabs');
    }

}
