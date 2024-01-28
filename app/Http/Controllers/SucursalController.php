<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Sucursal;
use Auth;

class SucursalController extends Controller
{
    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('sucursal.index',Auth::user()->empresa_id);
        }
        return view('sucursal.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $empresa = Empresa::find($empresa_id);
        $estados = Sucursal::ESTADOS;
        $sucursales = Sucursal::query()
                                ->byEmpresa($empresa_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('sucursal.index', compact('empresa','estados','sucursales'));
    }

    public function search(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);
        $estados = Sucursal::ESTADOS;
        $sucursales = Sucursal::query()
                                ->byEmpresa($request->empresa_id)
                                ->bySucursalId($request->sucursal_id)
                                ->bySucursal($request->sucursal)
                                ->byDireccion($request->direccion)
                                ->byTelefono($request->telefono)
                                ->byEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('sucursal.index', compact('empresa','estados','sucursales'));
    }

    public function create($id)
    {
        $empresa = Empresa::find($id);
        return view('sucursal.create', compact('empresa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required',
            'nombre' => 'required|unique:sucursales,nombre,null,id,empresa_id,' . $request->empresa_id,
            'ciudad' => 'required',
            'direccion' => 'required',
            'foto' => 'nullable|file|mimes:png|max:2048',
        ]);
        try{
            $sucursal = Sucursal::create([
                'empresa_id' => $request->empresa_id,
                'cliente_id' => Auth::user()->cliente_id,
                'nombre' => $request->nombre,
                'ciudad' => $request->ciudad,
                'direccion' => $request->direccion,
                'celular' => $request->celular,
                'estado' => '1'
            ]);

            return redirect()->route('sucursal.search',['empresa_id' => $request->empresa_id])->with('success_message', 'Se agregó una sucursal en la empresa seleccionada.');
        } catch (ValidationException $e) {
            return redirect()->route('sucursal.create',$request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id)
    {
        $sucursal = Sucursal::find($id);
        $empresa = Empresa::find($sucursal->empresa_id);
        return view('sucursal.editar', compact('sucursal','empresa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required',
            'nombre' => 'required|unique:sucursales,nombre,' . $request->sucursal_id . ',id,empresa_id,' . $request->empresa_id,
            'ciudad' => 'required',
            'direccion' => 'required',
            'foto' => 'nullable|file|mimes:png|max:2048',
        ]);
        try{
            $sucursal = Sucursal::find($request->sucursal_id);
            $sucursal->update([
                'empresa_id' => $request->empresa_id,
                'cliente_id' => Auth::user()->cliente_id,
                'nombre' => $request->nombre,
                'ciudad' => $request->ciudad,
                'direccion' => $request->direccion,
                'celular' => $request->celular,
                'estado' => $request->estado
            ]);

            return redirect()->route('sucursal.search',['empresa_id' => $request->empresa_id])->with('success_message', 'Se agregó una sucursal en la empresa seleccionada.');
        } catch (ValidationException $e) {
            return redirect()->route('sucursal.editar',$request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
