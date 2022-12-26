<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrCobrosDets extends Model
{
    protected $table = 'tr_cobros_dets';
    protected $primaryKey = "id";
    protected $fillable = [
        'cobrocab_id',
        'tipopago',
        'entidad_id',
        'referencia',
        'numero',
        'cuenta',
        'valor',
        'estado',
        'usuario',
    ];

    public function entidad(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

}
