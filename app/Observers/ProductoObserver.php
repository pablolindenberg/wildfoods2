<?php

namespace App\Observers;

use App\Producto;
use App\LogProducto;

class ProductoObserver
{
    public function created(Producto $producto)
    {
               
            $logProducto = new LogProducto();
            $logProducto->accion='Registrado';
            $logProducto->sku=$producto->SKU;
            $logProducto->nombreProducto=$producto->nombre;
            $logProducto->precioAnterior='0';
            $logProducto->precioNuevo=$producto->total;
            $logProducto->idUsuario=auth()->id();
            $logProducto->nombreUsuario=auth()->user()->usuario;
          
            $logProducto->save();

             
    }

    public function updating(Producto $producto)
    {
            $original = $producto->getOriginal();  
            $logProducto = new LogProducto();
            $logProducto->accion='Actualizado';
            $logProducto->sku=$producto->SKU;
            $logProducto->nombreProducto=$producto->nombre;
            $logProducto->precioAnterior=$original['total'];
            $logProducto->precioNuevo=$producto->total;
            $logProducto->idUsuario=auth()->id();
            $logProducto->nombreUsuario=auth()->user()->usuario;
          
            $logProducto->save();

             
    }


}