<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmProductos extends Model
{
    protected $table = 'tm_productos';
    protected $primaryKey = "id";
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'unidad',
        'talla',
        'categoria_id',
        'tipo',
        'tipo_iva',
        'maneja_stock',
        'stock',
        'stock_min',
        'precio',
        'foto',
        'estado',
        'usuario',
    ];



}
