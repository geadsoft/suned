<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmZonas extends Model
{
    protected $table = 'tm_zonas';
    protected $primaryKey = "id";
    protected $fillable = [
        'codigo',
        'descripcion',
        'superior',
        'estado',
        'root',
        'usuario',
    ];
}
