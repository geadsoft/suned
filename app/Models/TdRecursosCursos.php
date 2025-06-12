<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdRecursosCursos extends Model
{
    //use HasFactory;
    protected $table = 'td_recursos_cursos';
    protected $primaryKey = "id";
    protected $fillable = [
        'recurso_id',
        'curso_id',
        'usuario',
    ];
}
