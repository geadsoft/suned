<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmHorariosDocentes extends Model
{
    protected $table = 'tm_horarios_docentes';
    protected $primaryKey = "id";
    protected $fillable = [
        'horario_id',
        'asignatura_id',
        'docente_id',
        'usuario',
    ];

    public function asignatura(){
        return $this->belongsTo('App\Models\TmAsignaturas');
    }
    
}
