<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPensionesCab extends Model
{
    protected $table = 'tm_pensiones_cabs';
    protected $primaryKey = "id";
    protected $fillable = [
        'descripcion',
        'fecha',
        'periodo_id',
        'modalidad_id',
        'estado',
        'usuario',
    ];

    public function periodo(){
        return $this->belongsTo('App\Models\TmPeriodosLectivos');
    }

    public function modalidad(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }


}
