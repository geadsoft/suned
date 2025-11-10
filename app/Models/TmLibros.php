<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmLibros extends Model
{
    //use HasFactory;
    protected $table = 'tm_libros';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'docente_id',
        'nombre',
        'autor',
        'asignatura_id',
        'drive_id',
        'portada',
        'usuario',
    ];

    public function asignatura(){
        return $this->belongsTo('App\Models\TmAsignaturas');
    }

}
