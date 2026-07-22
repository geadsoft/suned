<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdExpedienteMatricula extends Model
{
    protected $table = 'td_expediente_matriculas';
    protected $primaryKey = "id";
    protected $fillable = [
        'expediente_matricula_id',
        'expediente_id',
        'nombre',
        'extension',
        'observacion',
        'documentacion_retirada',
        'drive_id',
        'usuario',
    ];
}
