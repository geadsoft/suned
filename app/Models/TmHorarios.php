<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmHorarios extends Model
{
    protected $table = 'tm_horarios';
    protected $primaryKey = "id";
    protected $fillable = [
        'grupo_id',
        'servicio_id',
        'periodo_id',
        'curso_id',
        'usuario',
    ];

    public function servicio(){
        return $this->belongsTo('App\Models\TmServicios');
    }

    public function grupo(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function curso(){
        return $this->belongsTo('App\Models\TmCursos');
    }

}
