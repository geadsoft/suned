<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmFamiliarEstudiantes extends Model
{
    protected $table = 'tm_familiar_estudiantes';
    protected $primaryKey = "id";
    protected $fillable = [
        'estudiante_id',
        'persona_id',
        'informacion',
        'usuario',
    ];

    public function persona(){
        return $this->belongsTo('App\Models\TmPersonas');
    }

}
