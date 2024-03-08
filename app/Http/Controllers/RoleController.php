<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Auth;

class RoleController extends Controller
{
    public function index()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        if(Auth::user()->id){
            $empresas = Empresa::pluck('nombre_comercial','id');
        }else{
            $empresas = Empresa::where('cliente_id',Auth::user()->cliente_id)->pluck('nombre_comercial','id');
        }
        $roles = Role::where('id','!=',1)->paginate(10);
        return view('roles.index', compact('empresas','roles'));
    }

    public function search(Request $request)
    {
        if(Auth::user()->id){
            $empresas = Empresa::pluck('nombre_comercial','id');
        }else{
            $empresas = Empresa::where('cliente_id',Auth::user()->cliente_id)->pluck('nombre_comercial','id');
        }
        $roles = Role::query()
                            ->byEmpresa($request->empresa_id)
                            ->byNombre($request->nombre)
                            ->where('id','!=',1)
                            ->paginate(10);
        return view('roles.index', compact('empresas','roles'));
    }

    public function getDatosByEmpresa(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $roles = Role::where('empresa_id', $id)->orderBy('id','asc')->get()->toJson();
            if($roles){
                return response()->json([
                    'roles' => $roles
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        if(Auth::user()->id){
            $empresas = Empresa::pluck('nombre_comercial','id');
        }else{
            $empresas = Empresa::where('cliente_id',Auth::user()->cliente_id)->pluck('nombre_comercial','id');
        }
        return view('roles.create',compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required',
            'nombre' => 'required|unique:roles,name',
        ]);
        try{
            $empresa = Empresa::find($request->empresa_id);
            $role = Role::create([
                'cliente_id' => $empresa->cliente_id,
                'empresa_id' => $request->empresa_id,
                'name' => $request->nombre
            ]);
            return redirect()->route('roles.index')->with('success_message', 'Se agregó un nuevo rol.');
        } catch (ValidationException $e) {
            return redirect()->route('roles.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id){
        $role = Role::find($id);
        $permisosOrdenados = $this->permisos_ordenados();
        $permissions = Permission::all();
        return view('roles.editar',compact('role','permissions','permisosOrdenados'));
    }

    public function update(Request $request){
        $role = Role::find($request->role_id);
        $role->permissions()->sync($request->permissions);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('roles.index')->with('success_message', 'Se agregó permisos.');
    }

    private function permisos_ordenados(){
        $permisos = Permission::orderBy('title')->get();
        $permisosOrdenados = array();
        $grupo = array();
        $title = $permisos[0]->title;
        foreach ($permisos as $permiso) {
            if($permiso->title == $title){
                if(count($grupo) == 0)
                    array_push($grupo,$permiso->title);
                    array_push($grupo,$permiso->id);
                    array_push($grupo,$permiso->description);
            }else{
                $title = $permiso->title;
                array_push($permisosOrdenados,$grupo);
                $grupo = array();
                array_push($grupo,$permiso->title);
                array_push($grupo,$permiso->id);
                array_push($grupo,$permiso->description);
            }
        }
        array_push($permisosOrdenados,$grupo);
        return $permisosOrdenados;
    }
}
