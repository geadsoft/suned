<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmRecursos extends Model
{
    //use HasFactory;
    protected $table = 'tm_recursos';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'asignatura_id',
        'docente_id',
        'nombre',
        'enlace',
        'estado',
        'usuario',
    ];

}
