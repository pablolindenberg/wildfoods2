<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;


 
class UserController extends Controller
{
    public function index(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.usuario','users.password',
            'users.estado','roles.nombre as rol')
            ->orderBy('users.id', 'desc')->paginate(3);
        }
        else{
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.usuario','users.password',
            'users.estado','roles.nombre as rol')       
            ->where('users.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('users.id', 'desc')->paginate(3);
        }
         
 
        return [
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'last_page'    => $users->lastPage(),
                'from'         => $users->firstItem(),
                'to'           => $users->lastItem(),
            ],
            'users' => $users
        ];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        try{
            DB::beginTransaction();
            // $persona = new Persona();
            // $persona->nombre = $request->nombre;
            // $persona->tipo_documento = $request->tipo_documento;
            // $persona->num_documento = $request->num_documento;
            // $persona->direccion = $request->direccion;
            // $persona->telefono = $request->telefono;
            // $persona->email = $request->email;
            // $persona->save();
 
            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->estado = '1';
            $user->idrol = $request->idrol;          
 
            
 
            $user->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
 
         
         
    }
 
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        try{
            DB::beginTransaction();
 
            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);
 
            // $persona = Persona::findOrFail($user->id);
 
            // $persona->nombre = $request->nombre;
            // $persona->tipo_documento = $request->tipo_documento;
            // $persona->num_documento = $request->num_documento;
            // $persona->direccion = $request->direccion;
            // $persona->telefono = $request->telefono;
            // $persona->email = $request->email;
            // $persona->save();
 
             
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();
 
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
 
    }
 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
 
 
}