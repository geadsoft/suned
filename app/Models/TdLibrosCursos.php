<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdLibrosCursos extends Model
{
    //use HasFactory;
    protected $table = 'td_libros_cursos';
    protected $primaryKey = "id";
    protected $fillable = [
        'libro_id',
        'curso_id',
        'usuario',
    ];

}
