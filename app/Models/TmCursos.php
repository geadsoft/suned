<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmCursos extends Model
{
    protected $table = 'tm_cursos';
    protected $primaryKey = "id";
    protected $fillable = [
        'nivel_id',
        'grado_id',
        'paralelo',
        'grupo_id',
        'especializacion_id',
        'vistaplataforma',
        'periodo_id',
        'estado',
        'usuario',
    ];

    public function grado(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function grupo(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function nivel(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function especializacion(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

}
