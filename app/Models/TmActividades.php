<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmActividades extends Model
{
    //use HasFactory;

    protected $table = 'tm_actividades';
    protected $primaryKey = "id";
    protected $fillable = [
        'docente_id',
        'paralelo',
        'termino',
        'bloque',
        'tipo',
        'actividad',
        'nombre',
        'descripcion',
        'fecha',
        'subir_archivo',
        'puntaje',
        'enlace',
        'fecha_entrega',
        'comentario',
        'estado',
        'usuario',
    ];

}
