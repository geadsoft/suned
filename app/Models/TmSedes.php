<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmSedes extends Model
{
    protected $table = 'tm_sedes';
    protected $primaryKey = "id";
    protected $fillable = [
        'codigo',
        'nombre',
        'denominacion',
        'inicia_actividad',
        'telefono_sede',
        'email_sede',
        'website',
        'representante',
        'identificacion',
        'fin_semana',
        'jornada_completa',
        'matutino',
        'vespertino',
        'nocturno',
        'provincia_id',
        'canton_id',
        'parroquia_id',
        'direccion_sede',
        'logo_sede',
        'ruc',
        'razon_social',
        'nombre_comercial',
        'telefono',
        'email',
        'direccion',
        'lleva_contabilidad',
        'regimen_rimpe',
        'contribuyente_especial',
        'resolucion_ce',
        'agente_retencion',
        'resolucion_ar',
        'establecimiento',
        'nombre_establecimiento',
        'direccion_establecimiento',
        'punto_emision',
        'secuencia_factura',
        'secuencia_ncredito',
        'archivo_firma',
        'clave_firma',
        'ambiente',
        'docgenerado',
        'docautorizado',
        'logo_factura',
        'usuario',
        'rector',
        'secretaria',
        'coordinador',
    ];

    /*public function provincia(){
        return $this->belongsTo('App\Models\TmZonas');
    }

    public function canton(){
        return $this->belongsTo('App\Models\TmZonas');
    }

    public function parroquia(){
        return $this->belongsTo('App\Models\TmZonas');
    }*/

}
