<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrDeudasCabs extends Model
{
    protected $table = 'tr_deudas_cabs';
    protected $primaryKey = "id";
    protected $fillable = [
        'estudiante_id',
        'periodo_id',
        'referencia',
        'fecha',
        'basedifgravada',
        'basegravada',
        'impuesto',
        'descuento',
        'neto',
        'debito',
        'credito',
        'saldo',
        'glosa',
        'estado',
        'usuario',
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

    public function periodo(){
        return $this->belongsTo('App\Models\TmPeriodoLectivos');
    }

}
