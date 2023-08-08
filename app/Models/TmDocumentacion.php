<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmDocumentacion extends Model
{
    protected $table = 'tm_documentacion';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'estudiante_id',
        'servicio_id',
        'documentacion_id',
        'carpeta',
        'archivo',
        'usuario',
    ];
}
