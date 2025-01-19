<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmCalendarioEventos extends Model
{
    //use HasFactory;

    protected $table = 'tm_calendario_eventos';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo',
        'mes',
        'actividad',
        'nombre',
        'start_date',
        'end_date',
        'descripcion',
        'usuario',
    ];


}
