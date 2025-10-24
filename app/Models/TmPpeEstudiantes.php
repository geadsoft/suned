<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPpeEstudiantes extends Model
{
    //use HasFactory;
    protected $table = 'tm_ppe_estudiantes';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'modalidad_id',
        'grado_id',
        'persona_id',
        'usuario',
    ];
}
