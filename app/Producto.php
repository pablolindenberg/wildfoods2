<?php

namespace App;

use App\Events\ProductoSaved;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{   
    // protected $dispatchesEvents =[
    //     "saved"=> ProductoSaved::class
    // ];

    protected $fillable = [
    'idcategoria',
    'SKU',
    'nombre',
    'marca',
    'descripcion',
    'contenido_display',
    'valor_neto',
    'valor_bruto',
    'pvp_unitario',
    'total_neto',
    'total',
    'descuento',
    'imagen',
    'stock',
    'estado'
	
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function detalle_pedido(){
        return $this->hasMany('App\Detalle_Pedido');
    }
}
