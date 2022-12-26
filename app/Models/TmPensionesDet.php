<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPensionesDet extends Model
{
    protected $table = 'tm_pensiones_dets';
    protected $primaryKey = "id";
    protected $fillable = [
        'pension_id',
        'nivel_id',
        'matricula',
        'matricula2',
        'pension',
        'plataforma',
        'estado',
        'usuario',
    ];

    public function nivel(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }


}
