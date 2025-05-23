<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmHorariosAsignaturas extends Model
{
    protected $table = 'tm_horarios_asignaturas';
    protected $primaryKey = "id";
    protected $fillable = [
        'horario_id',
        'linea',
        'dia',
        'asignatura_id',
        'hora_id',
        'usuario',
    ];

}
