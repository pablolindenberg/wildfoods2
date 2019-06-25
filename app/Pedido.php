<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'idusuario',
        'total',
        'estado',
        'tracking',
        'fecha_creacion',
        'fecha_actualizacion',   
        
        ];
        public function user(){
            return $this->belongsTo('App\User');
        }
}
