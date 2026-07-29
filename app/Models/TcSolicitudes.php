<?php

namespace App\Models;
use App\Models\TdSolicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TcSolicitudes extends Model
{
    //use HasFactory;
    protected $table = 'tc_solicitudes';
    protected $primaryKey = "id";
    protected $fillable = [
        'documento',
        'fecha',
        'solicitante',
        'nui',
        'persona_id',
        'fecha_entrega',
        'servidor',
        'forma_solicitud',
        'celular',
        'telefono',
        'email',
        'observacion',
        'estado',
        'usuario',
    ];

    public function detalles()
    {
        return $this->hasMany(
            TdSolicitudes::class,
            'solicitud_id'
        );
    }

    public function persona()
    {
        return $this->belongsTo(
            TmPersonas::class,
            'persona_id'
        );
    }
}
