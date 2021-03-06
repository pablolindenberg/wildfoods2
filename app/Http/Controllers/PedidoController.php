<?php

namespace App\Http\Controllers;
use App\Exports\PedidosExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Notifications\TemplateEmail;
use App\User;
use App\Pedido;
use App\Detalle_pedido;
use App\Http\Controllers\Controller;


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
            ->select('pedidos.id','users.id as id_usuario','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.bodega','pedidos.created_at','pedidos.updated_at','pedidos.factura')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
        }
        else{
            $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.id as id_usuario','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.bodega','pedidos.created_at','pedidos.updated_at','pedidos.factura')
            ->where('pedidos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
        }
    }
    elseif($rol==2){
        $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.bodega','pedidos.created_at','pedidos.updated_at','pedidos.factura')
            ->where('pedidos.bodega', 'like','1')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
    }
    else{

        $buscar=$request->user()->id;
        $criterio="idusuario";

        if ($buscar==''){
            $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.created_at','pedidos.updated_at','pedidos.factura')
            ->orderBy('pedidos.id', 'desc')->paginate(10);
        }
        else{
            $pedidos = Pedido::join('users','pedidos.idusuario','=','users.id')
            ->select('pedidos.id','users.usuario as nombre_usuario','users.email as email_usuario','pedidos.total','pedidos.estado','pedidos.tracking','pedidos.created_at','pedidos.updated_at','pedidos.factura')
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
        // if (!$request->ajax()) return redirect('/');
        // $pedido = Pedido::findOrFail($request->id);
        // $pedido->factura = $request->factura;
        // $pedido->save();
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->idusuario=$request->idusuario;
        $pedido->tracking=$request->tracking;
        $pedido->save();
        
    }
    public function cargarFactura(Request $request)
    {
         if (!$request->ajax()) return redirect('/');
         $pedido = Pedido::findOrFail($request->idpedido);
         $pedido->factura = 1;
         $pedido->save();
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
    public function despachado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->estado = '2';
        $pedido->save();

       // $user = new User();
        $user = User::findOrFail($request->idusuario);
       // $user->email = 'alfombra.roja.santiago@gmail.com';   // This is the email you want to send to.
        $user->notify(new TemplateEmail());
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
    public function descargar(Request $request){
       
       // $id= Integer.parse_str($request->idusuario);

       // return Excel::download(new PedidosExport($id),'pedidos.xlsx');
        return Excel::download(new PedidosExport(),'pedidos.xlsx');
       
    }
      
}
