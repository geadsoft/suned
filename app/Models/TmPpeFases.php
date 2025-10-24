<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmPpeFases extends Model
{
    //use HasFactory;
    protected $table = 'tm_ppe_fases';
    protected $primaryKey = "id";
    protected $fillable = [
        'periodo_id',
        'persona_id',
        'fase',
        'fecha',
        'enlace',
        'usuario',
    ];

}
