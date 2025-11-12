<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdPpeAsistencias extends Model
{
    //use HasFactory;
    protected $table = 'td_ppe_asistencias';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'docente_id',
        'fase',
        'curso_id',
        'persona_id',
        'fecha',
        'valor',
        'usuario'
    ];

    public function persona(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

}
