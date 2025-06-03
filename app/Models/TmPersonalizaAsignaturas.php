<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPersonalizaAsignaturas extends Model
{
    protected $table = 'tm_personaliza_asignaturas';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'asignatura_id',
        'nombre',
        'imagen',
        'abreviatura',
    ];
}
