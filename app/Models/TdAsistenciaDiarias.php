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
        'docente_id',
        'asignatura_id',
        'curso_id',
        'persona_id',
        'fecha',
        'falta',
        'usuario'
    ];

    public function persona(){
        return $this->belongsTo('App\Models\TmPersonas');
    }
    
}
