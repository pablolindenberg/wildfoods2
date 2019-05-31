<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{ 
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
    'estado',
	'imagen'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
