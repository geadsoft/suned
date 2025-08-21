<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPaseCursos extends Model
{
    protected $table = 'tm_pase_cursos';
    protected $primaryKey = "id";
    protected $fillable = [
        'matricula_id',
        'estudiante_id',
        'modalidad_id',
        'nivel_id',
        'grado_id',
        'curso_id',
        'curso_anterior',
        'estado',
        'usuario',
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

    public function grado(){
        return $this->belongsTo('App\Models\TmServicios');
    }

    public function modalidad(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

     public function curso(){
        return $this->belongsTo('App\Models\TmCursos');
    }

}
