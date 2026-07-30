<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmSubcategoriasSolicitud extends Model
{
    //use HasFactory;
    protected $table = 'tm_subcategoria_solicitudes';
    protected $primaryKey = "id";
    protected $fillable = [
        'categoria',
        'subcategoria',
        'tiempo_entrega',
        'usuario',
    ];

}
