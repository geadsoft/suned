<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmHorarios extends Model
{
    protected $table = 'tm_horarios';
    protected $primaryKey = "id";
    protected $fillable = [
        'servicios_id',
        'periodo_id',
        'curso_id',
        'usuario',
    ];

    public function servicios(){
        return $this->belongsTo('App\Models\TmServicios');
    }


}
