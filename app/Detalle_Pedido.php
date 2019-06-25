<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Pedido extends Model
{
    protected $fillable = [
        'idpedido',
        'idproducto',
        'cantidad',
        'total',    
        ];
        public function pedido(){
            return $this->belongsTo('App\Pedido');
        }
        public function producto(){
            return $this->belongsTo('App\Producto');
        }
}
