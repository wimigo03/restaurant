<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Empresa;

class UserController extends Controller
{
    public function index()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        $estados = User::ESTADOS;
        $users = User::where('id','!=',1)->paginate(10);
        return view('users.index', compact('users','estados','empresas'));
    }

    public function search(Request $request)
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        $estados = User::ESTADOS;
        $users = User::query()
                        ->byEmpresa($request->empresa_id)
                        ->byCargo($request->cargo_id)
                        ->byRole($request->role_id)
                        ->byNombre($request->nombre)
                        ->byUsername($request->username)
                        ->byEmail($request->email)
                        ->byEstado($request->estado)
                        ->where('id','!=',1)
                        ->paginate(10);
        return view('users.index', compact('users','estados','empresas'));
    }

    public function editar($id)
    {
        $user = User::find($id);
        return view('users.editar', compact('user'));
    }

    public function update(Request $request){
        try{
            $user = User::find($request->user_id);
            if($request->password != null){
                $user->update([
                    'cargo_id' => $request->cargo_id,
                    'empresa_id' => $request->empresa_id,
                    'cliente_id' => $request->cliente_id,
                    'name' => $request->nombre,
                    'email' => $request->email,
                    'password' => bcrypt($request->password)
                ]);
            }else{
                $user->update([
                    'cargo_id' => $request->cargo_id,
                    'empresa_id' => $request->empresa_id,
                    'cliente_id' => $request->cliente_id,
                    'name' => $request->nombre,
                    'email' => $request->email
                ]);
            }
            return redirect()->route('users.index')->with('success_message', 'Se modificaron los datos del usuario seleccionado...');
        } catch (ValidationException $e) {
            return redirect()->route('users.editar')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function habilitar($id){
        try{
            $user = User::find($id);
            $user->update([
                'estado' => '1'
            ]);
            return redirect()->route('users.index')->with('success_message', 'Se Habilito usuario seleccionado...');
        } catch (ValidationException $e) {
            return redirect()->route('users.index')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function deshabilitar($id){
        try{
            $user = User::find($id);
            $user->update([
                'estado' => '2'
            ]);
            return redirect()->route('users.index')->with('success_message', 'Se Habilito usuario seleccionado...');
        } catch (ValidationException $e) {
            return redirect()->route('users.index')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function asignar($id)
    {
        $user = User::find($id);
        $roles = Role::where('id','!=',1)->get();
        return view('users.asignar', compact('user','roles'));
    }

    public function asignacion(Request $request){
        $user = User::find($request->user_id);
        $user->roles()->sync($request->roles);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('users.index')->with('success_message', 'Se agregó Roles.');
    }
}
