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
        'tipo',
        'documento',
        'concepto',
        'monto',
        'estado',
        'usuario',
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }
    
}
