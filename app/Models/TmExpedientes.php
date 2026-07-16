<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TmServicios;

class TmExpedientes extends Model
{   
    protected $casts = [
        'servicios' => 'array',
    ];

    //use HasFactory;
    protected $table = 'tm_expedientes';
    protected $primaryKey = "id";
    protected $fillable = [
        'descripcion',
        'servicios',
        'estado',
        'usuario',
    ];

    public function getPrimerServicioAttribute()
    {
        $servicios = $this->servicios ?? [];

        if (empty($servicios)) {
            return null;
        }

        return TmServicios::find($servicios[0])?->descripcion;
    }

    public function getUltimoServicioAttribute()
    {
        $servicios = $this->servicios ?? [];

        if (empty($servicios)) {
            return null;
        }

        $id = $servicios[array_key_last($servicios)];

        return TmServicios::find($id)?->descripcion;
    }

}
