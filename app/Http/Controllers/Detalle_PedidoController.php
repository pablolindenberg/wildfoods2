<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalle_pedido;

class Detalle_pedidoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        //$detalle_pedidos = Detalle_pedido::orderBy('idpedido', 'desc')->paginate(3);
     
        if ($buscar==''){
            $detalle_pedidos = Detalle_Pedido::join('pedidos','detalle_pedidos.idpedido','=','pedidos.id')
            ->join('productos','detalle_pedidos.idproducto','productos.id')
            ->select('productos.SKU','productos.nombre','productos.total as unitario_producto','detalle_pedidos.cantidad','detalle_pedidos.total')
            ->orderBy('detalle_pedidos.id', 'desc')->paginate(10);
        }
        else{
            $detalle_pedidos = Detalle_Pedido::join('pedidos','detalle_pedidos.idpedido','=','pedidos.id')
            ->join('productos','detalle_pedidos.idproducto','productos.id')
            ->select('productos.SKU','productos.nombre','productos.total as unitario_producto','detalle_pedidos.cantidad','detalle_pedidos.total')
            ->where('detalle_pedidos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('detalle_pedidos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $detalle_pedidos->total(),
                'current_page' => $detalle_pedidos->currentPage(),
                'per_page'     => $detalle_pedidos->perPage(),
                'last_page'    => $detalle_pedidos->lastPage(),
                'from'         => $detalle_pedidos->firstItem(),
                'to'           => $detalle_pedidos->lastItem(),
            ],
            'detalle_pedidos' => $detalle_pedidos
        ];
    }   
 
    //todos los metodos sin stock
    public function store(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');

        // $cart=$request->cart;
        // for($i=0;$i<=$cart.lenght;$i++){

        // $detalle_pedidos = new detalle_pedidos();

        // $detalle_pedidos->idpedido = $cart[$i].idpedido;
        // $detalle_pedidos->idproducto = $cart[$i].idproducto;
        // $detalle_pedidos->cantidad = $cart[$i].cantidad;
        // $detalle_pedidos->total = $cart[$i].total;

        // $detalle_pedidos->save();
        // }
       
      
        $cart= $request->cart;

        $detalle_pedido = new Detalle_pedido();
   

        //  $detalle_pedido->idpedido=$cart[0]['idpedido'];
        //  $detalle_pedido->idproducto=$cart[0]['idproducto'];
        //  $detalle_pedido->cantidad=$cart[0]['cantidad'];
        //  $detalle_pedido->total=$cart[0]['total'];
         $detalle_pedido->save();
       
 
    
    }


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->idcategoria = $request->idcategoria;
        $producto->SKU = $request->SKU;
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->descripcion = $request->descripcion;
        $producto->contenido_display = $request ->contenido_display;
        $producto->valor_neto = $request->valor_neto;
        $producto->valor_bruto = $request->valor_bruto;
        $producto->pvp_unitario = $request->pvp_unitario;
        $producto->total_neto = $request->total_neto;
        $producto->total = $request->total;
        $producto->descuento = $request->descuento;
        $producto->estado = $request->estado;
      //  $producto->imagen = $request->imagen;      
        $producto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->estado = '0';
        $pedido->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->estado = '1';
        $pedido->save();
    }
}
