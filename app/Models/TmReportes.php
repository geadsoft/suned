<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmReportes extends Model
{
    protected $table = 'tm_reportes';
    protected $primaryKey = "id";
    protected $fillable = [
        'tipo',
        'emision',
        'periodo',
        'identificacion',
        'nombres',
        'curso',
        'especializacion',
        'folio',
        'matricula',
        'fecha',
        'nota',
        'escala',
        'rector',
        'asunto',
        'destinatario',
        'institucion',
        'cargo',
        'refrendacion',
        'pagina',
        'fprorroga',
        'documento',
        'matricula_id',
        'curso_promovido',
        'secretaria',
        'coordinador',
    ];
}
