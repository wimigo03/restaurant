<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Auth;

class RoleController extends Controller
{
    const ICONO = 'fas fa-user-shield fa-fw';
    const INDEX = 'ROLES';
    const CREATE = 'REGISTRAR ROL';

    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('role.index.index',Auth::user()->empresa_id);
        }
        return view('roles.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($empresa_id);
        $roles = Role::where('id','!=',1)->paginate(10);
        return view('roles.index', compact('icono','header','empresa','roles'));
    }

    public function search(Request $request)
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($request->empresa_id);
        $roles = Role::query()
                        ->byEmpresa($request->empresa_id)
                        ->byNombre($request->nombre)
                        ->where('id','!=',1)
                        ->paginate(10);
        return view('roles.index', compact('icono','header','empresa','roles'));
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

    public function create($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($empresa_id);
        return view('roles.create',compact('icono','header','empresa'));
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
            return redirect()->route('roles.index',$request->empresa_id)->with('success_message', 'Se agregó un nuevo rol.');
        } catch (ValidationException $e) {
            return redirect()->route('roles.create',$request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id){
        $icono = self::ICONO;
        $header = self::INDEX;
        $role = Role::find($id);
        $empresa = Empresa::find($role->empresa_id);
        $permisosOrdenados = $this->permisos_ordenados();
        $permissions = Permission::all();
        return view('roles.editar',compact('icono','header','empresa','role','permissions','permisosOrdenados'));
    }

    public function update(Request $request){
        $role = Role::find($request->role_id);
        $role->permissions()->sync($request->permissions);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('roles.index',$role->empresa_id)->with('success_message', 'Se agregó permisos.');
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
