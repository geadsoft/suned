<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmCalendarioGrados extends Model
{
    //use HasFactory;
    protected $table = 'tm_calendario_grados';
    protected $primaryKey = "id";
    protected $fillable = [
        'calendario_id',
        'modalidad_id',
        'grado_id',
        'usuario',
    ];
}
