<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidad;
use App\Models\Empresa;
use Auth;

class UnidadController extends Controller
{
    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('unidades.index',Auth::user()->empresa_id);
        }
        return view('unidades.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $empresa = Empresa::find($empresa_id);
        $estados = Unidad::ESTADOS;
        $tipos = Unidad::TIPOS;
        $unidades = Unidad::query()
                                ->byEmpresa($empresa_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('unidades.index', compact('empresa','estados','tipos','unidades'));
    }

    public function search(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);
        $estados = Unidad::ESTADOS;
        $tipos = Unidad::TIPOS;
        $unidades = Unidad::query()
                                ->byEmpresa($request->empresa_id)
                                ->byNombre($request->nombre)
                                ->byCodigo($request->codigo)
                                ->byTipo($request->tipo)
                                ->byEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('unidades.index', compact('empresa','estados','tipos','unidades'));
    }

    public function create($id)
    {
        $empresa = Empresa::find($id);
        $tipos = Unidad::TIPOS;
        return view('unidades.create', compact('empresa','tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:unidades,nombre,null,id,empresa_id,' . $request->empresa_id,
            'codigo' => 'required|max:4|unique:unidades,codigo,null,id,empresa_id,' . $request->empresa_id,
            'tipo' => 'required'
        ]);
        try{
            $empresa = Empresa::find($request->empresa_id);
            $unidad = Unidad::create([
                'empresa_id' => $request->empresa_id,
                'cliente_id' => $empresa->cliente_id,
                'nombre' => $request->nombre,
                'codigo' => $request->codigo,
                'tipo' => $request->tipo,
                'estado' => '1'
                ]);
            
                if(isset($request->form_prod)){
                    return back()->with('success_message', 'Se agregó un unidad de medida correctamente.');;
                }
            return redirect()->route('unidades.index',['empresa_id' => $request->empresa_id])->with('success_message', 'Se agregó un unidad de medida correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('unidades.create',$request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
