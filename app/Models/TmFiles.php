<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmFiles extends Model
{
    protected $table = 'tm_files';
    protected $primaryKey = "id";
    protected $fillable = [
        'actividad_id',
        'persona_id',
        'nombre',
        'extension',
        'entrega',
        'drive_id',
        'usuario',
    ];

}
