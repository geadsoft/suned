<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrCalificacionesDets extends Model
{
    protected $table = 'tr_calificaciones_dets';
    protected $primaryKey = "id";
    protected $fillable = [
        'calificacioncab_id',
        'estudiante_id',
        'fecha',
        'calificacion',
        'escala_cualitativa',
        'observacion',
        'usuario',
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

}
