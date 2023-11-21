<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrCalificacionesCabs extends Model
{
    protected $table = 'tr_calificaciones_cabs';
    protected $primaryKey = "id";
    protected $fillable = [
        'fecha',
        'grupo_id',
        'servicio_id',
        'periodo_id',
        'curso_id',
        'asignatura_id',
        'ciclo_academico',
        'parcial',
        'usuario',
    ];

    public function servicio(){
        return $this->belongsTo('App\Models\TmServicios');
    }

    public function curso(){
        return $this->belongsTo('App\Models\TmCursos');
    }

    public function asignatura(){
        return $this->belongsTo('App\Models\TmAsignaturas');
    }


}
