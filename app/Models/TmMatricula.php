<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmMatricula extends Model
{
    protected $table = 'tm_matriculas';
    protected $primaryKey = "id";
    protected $fillable = [
        'documento',
        'registro',
        'fecha',
        'estudiante_id',
        'nivel_id',
        'modalidad_id',
        'grado_id',
        'periodo_id',
        'curso_id',
        'representante_id',
        'comentario',
        'estado',
        'usuario',
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

    public function curso(){
        return $this->belongsTo('App\Models\TmCursos');
    }

    public function modalidad(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

}
