<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmAsignaturas extends Model
{
    protected $table = 'tm_asignaturas';
    protected $primaryKey = "id";
    protected $fillable = [
        'area_id',
        'descripcion',
        'estado',
        'usuario',
    ];

    public function area(){
        return $this->belongsTo('App\Models\TmGeneralidades');
    }
    
}

