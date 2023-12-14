<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrRegistrocasDet extends Model
{
    //use HasFactory;
    protected $table = 'tr_registrocas_det';
    protected $primaryKey = "id";
    protected $fillable = [
        'registrocas_id',
        'matricula_id',
        'curso_id',
        'usuario',
    ];

    

}
