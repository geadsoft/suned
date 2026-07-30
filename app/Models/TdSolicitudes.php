<?php

namespace App\Models;
use App\Models\TmSubcategoriasSolicitud;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdSolicitudes extends Model
{
    //use HasFactory;
    protected $table = 'td_solicitudes';
    protected $primaryKey = "id";
    protected $fillable = [
        'solicitud_id',
        'subcategoria_id',
        'periodo_id',
        'curso_id',
        'usuario',
    ];
    

    public function subcategoria()
    {
        return $this->belongsTo(
            TmSubcategoriasSolicitud::class,
            'subcategoria_id'
        );
    }

    public function periodo()
    {
        return $this->belongsTo(
            TmPeriodosLectivos::class,
            'periodo_id'
        );
    }

    public function curso()
    {
        return $this->belongsTo(
            TmServicios::class,
            'curso_id'
        );
    }
}
