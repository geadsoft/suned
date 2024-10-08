<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrCobrosCabs extends Model
{
    protected $table = 'tr_cobros_cabs';
    protected $primaryKey = "id";
    protected $fillable = [
        'fecha',
        'estudiante_id',
        'matricula_id',
        'tipo',
        'documento',
        'fechapago',
        'concepto',
        'monto',
        'estado',
        'comentario',
        'usuario',
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

    public function matricula(){
        return $this->belongsTo('App\Models\TmMatricula');
    }
    
}
