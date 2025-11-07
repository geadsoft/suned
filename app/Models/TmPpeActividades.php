<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPpeActividades extends Model
{
    //use HasFactory;
    protected $table = 'tm_ppe_actividades';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'docente_id',
        'modalidad_id',
        'grado_id',
        'tipo',
        'actividad',
        'nombre',
        'descripcion',
        'fecha_entrega',
        'subir_archivo',
        'puntaje',
        'enlace',
        'estado',
        'usuario',
    ];

    public function modalidad(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function grado(){
        return $this->belongsTo('App\Models\TmServicios');
    }
}
