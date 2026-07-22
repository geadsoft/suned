<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmExpedienteMatricula extends Model
{
    
    protected $table = 'tm_expediente_matriculas';
    protected $primaryKey = "id";
    protected $fillable = [
        'matricula_id',
        'documentacion_completa',
        'comentario_impresion',
        'comentario_secretaria',
        'documentacion_retirada',
        'comentario_retiro',
        'estado',
        'usuario',
    ];

    protected $casts = [
        'documentacion_completa' => 'boolean',
    ];

    public function detalles()
    {
        return $this->hasMany(
            TdExpedienteMatricula::class,
            'expediente_matricula_id',
            'id'
        );
    }

}
