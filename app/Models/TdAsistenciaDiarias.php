<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdAsistenciaDiarias extends Model
{
    //use HasFactory;
    protected $table = 'td_asistencia_diarias';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'mes',
        'docente_id',
        'termino',
        'asignatura_id',
        'curso_id',
        'persona_id',
        'fecha',
        'valor',
        'usuario'
    ];

    public function persona(){
        return $this->belongsTo('App\Models\TmPersonas');
    }
    
}
