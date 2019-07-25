<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Producto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.SKU','productos.nombre','categorias.nombre as nombre_categoria','productos.marca','productos.descripcion','productos.contenido_display','productos.valor_neto','productos.valor_bruto','productos.pvp_unitario','productos.total_neto','productos.total','productos.descuento','productos.stock','productos.imagen','productos.estado')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.SKU','productos.nombre','categorias.nombre as nombre_categoria','productos.marca','productos.descripcion','productos.contenido_display','productos.valor_neto','productos.valor_bruto','productos.pvp_unitario','productos.pvp_unitario','productos.total_neto','productos.total','productos.descuento','productos.stock','productos.imagen','productos.estado')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }   
 
    //todos los metodos sin stock
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = new Producto();
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
    
       if ($request->imagen){
        
        $name = "Wildfoods-".time(). '.' . explode('/', explode(':', substr($request->imagen,0,strpos($request->imagen,';')))[1])[1];
        
        \Image::make($request->imagen)->save(public_path('img/productos/').$name);

                $request->imagen = $name;
         }   
         
         $producto->imagen = $request->imagen;  
          
        $producto->save();
        return ['message' => "Wena"];
    }


////////////////

    public function cargarImagen(Request $request){

      

        if ($request->imagen){
    
            $name = "Wildfoods-".time(). '.' . explode('/', explode(':', substr($request->imagen,0,strpos($request->imagen,';')))[1])[1];
    
            \Image::make($request->imagen)->save(public_path('img/productos/').$name);

 
       }

    }

////////////////////


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

        // Updatear la foto:
        $currentFoto =  $producto->imagen;
        if ($request->imagen != $currentFoto){
        
            $name = "Wildfoods-".time(). '.' . explode('/', explode(':', substr($request->imagen,0,strpos($request->imagen,';')))[1])[1];
            
            \Image::make($request->imagen)->save(public_path('img/productos/').$name);
    
                    $request->merge(['imagen' => $name]);

            // Borrar fotos del servidor si se actualiza a una nueva
            
            $productoFoto = public_path('img/productos/').$currentFoto;

            if (file_exists($productoFoto)){

                @unlink($productoFoto);
            }


        }   

        //$producto->save();
        $producto->update($request->all());
        return ['message ' => 'exito!!!'];
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->estado = '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->estado = '1';
        $producto->save();
    }
}
