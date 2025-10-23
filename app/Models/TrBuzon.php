<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrBuzon extends Model
{
    //use HasFactory;
    protected $table = 'tr_buzons';
    protected $primaryKey = "id";
    protected $fillable = [
        'categoria',
        'tipo',
        'identificacion',
        'estado',
        'nombres',
        'email',
        'telefono',
        'comentario',
        'usuario',
    ];
}
