<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'idusuario',
        'total',
        'estado',
        'bodega',
        'tracking',
        'fecha_creacion',
        'fecha_actualizacion',   
        
        ];
        public function user(){
            return $this->belongsTo('App\User');
        }
        public function detalle_pedido(){
            return $this->hasMany('App\Detalle_Pedido');
        }
}
