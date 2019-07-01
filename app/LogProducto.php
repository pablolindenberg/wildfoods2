<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogProducto extends Model
{

    protected $fillable = [
        'accion',
        'sku',
        'nombreProducto',
        'precioAnterior',
        'precioNuevo',
        'idUsuario',
        'nombreUsuario'
        
        ];
  
}
