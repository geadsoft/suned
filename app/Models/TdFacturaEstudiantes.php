<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdFacturaEstudiantes extends Model
{
    protected $table = 'td_factura_estudiantes';
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
