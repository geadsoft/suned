<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmServicios extends Model
{
    protected $table = 'tm_servicios';
    protected $primaryKey = "id";
    protected $fillable = [
        'descripcion',
        'modalidad_id',
        'nivel_id',
        'grado_id',
        'especializacion_id',
        'estado',
        'usuario',
    ];

    public function modalidad(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function nivel(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function grado(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

    public function especializacion(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }

}
