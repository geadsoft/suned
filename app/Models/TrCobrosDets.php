<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrCobrosDets extends Model
{
    protected $table = 'tr_cobros_dets';
    protected $primaryKey = "id";
    protected $fillable = [
        'cobroscab_id',
        'tipopago',
        'entidad_id',
        'intitucion',
        'numero',
        'cuenta',
        'valor',
        'estado',
        'usuario',
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

}
