<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\Detalle_pedido;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $rol = $request->user()->idrol;

        if($rol==1){
        if ($buscar==''){
            $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.bodega','pedidos.created_at','pedidos.updated_at')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
        }
        else{
            $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.bodega','pedidos.created_at','pedidos.updated_at')
            ->where('pedidos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
        }
    }else{

        $buscar=$request->user()->id;
        $criterio="idusuario";

        if ($buscar==''){
            $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.created_at','pedidos.updated_at')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
        }
        else{
            $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.created_at','pedidos.updated_at')
            ->where('pedidos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
        }  
    }



        return [
            'pagination' => [
                'total'        => $pedidos->total(),
                'current_page' => $pedidos->currentPage(),
                'per_page'     => $pedidos->perPage(),
                'last_page'    => $pedidos->lastPage(),
                'from'         => $pedidos->firstItem(),
                'to'           => $pedidos->lastItem(),
            ],
            'pedidos' => $pedidos
        ];
    }   
 
    //todos los metodos sin stock
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
       
        $pedido = new Pedido();

        $pedido->idusuario = $request->user()->id;
       // $pedido->idusuario = $request->idusuario;
        $pedido->total = $request->total;
        $pedido->tracking="NA";
        $pedido->estado = 1; 
        $pedido->bodega = 0;   

       // $pedido->created_at =date("F j, Y, g:i a");  
       // $pedido->updated_at = date("F j, Y, g:i a");  
        
        $pedido->save();
            
       $cart= $request->cart;

       for($i=0;$i<sizeof($cart);$i++){
        $detalle_pedido = new Detalle_pedido();    
       $detalle_pedido->idpedido=$pedido->id;
       $detalle_pedido->idproducto=$cart[$i]['id'];
       $detalle_pedido->cantidad=$cart[$i]['cantidad'];
       $detalle_pedido->total=$cart[$i]['total'];
       $detalle_pedido->save();
    }
    }
 
    public function update(Request $request)
    {
    //     if (!$request->ajax()) return redirect('/');
    //     $producto = Producto::findOrFail($request->id);
    //     $producto->idcategoria = $request->idcategoria;
    //     $producto->SKU = $request->SKU;
    //     $producto->nombre = $request->nombre;
    //     $producto->marca = $request->marca;
    //     $producto->descripcion = $request->descripcion;
    //     $producto->contenido_display = $request ->contenido_display;
    //     $producto->valor_neto = $request->valor_neto;
    //     $producto->valor_bruto = $request->valor_bruto;
    //     $producto->pvp_unitario = $request->pvp_unitario;
    //     $producto->total_neto = $request->total_neto;
    //     $producto->total = $request->total;
    //     $producto->descuento = $request->descuento;
    //     $producto->estado = $request->estado;
    //   // $producto->imagen = $request->imagen;      
    //     $producto->save();
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

    public function desactivarBodega(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->bodega = '0';
        $pedido->save();
    }
    public function activarBodega(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->bodega = '1';
        $pedido->save();
    }


}
