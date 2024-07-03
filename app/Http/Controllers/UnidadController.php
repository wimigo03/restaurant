<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidad;
use App\Models\Empresa;
use Auth;

class UnidadController extends Controller
{
    const ICONO = 'fas fa-balance-scale fa-fw';
    const INDEX = 'UNIDADES DE MEDIDA';
    const CREATE = 'REGISTRAR UNIDAD DE MEDIDA';
    const EDITAR = 'MODIFICAR UNIDAD DE MEDIDA';

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

    public function index()
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresas = Empresa::query()->byPiCliente(Auth::user()->pi_cliente_id)->pluck('nombre_comercial','id');
        $estados = Unidad::ESTADOS;
        $tipos = Unidad::TIPOS;
        $unidades = Unidad::query()
                                ->byPiCliente(Auth::user()->pi_cliente_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('unidades.index', compact('icono','header','empresas','estados','tipos','unidades'));
    }

    public function search(Request $request)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresas = Empresa::query()->byPiCliente(Auth::user()->pi_cliente_id)->pluck('nombre_comercial','id');
        $estados = Unidad::ESTADOS;
        $tipos = Unidad::TIPOS;
        $unidades = Unidad::query()
                                ->byPiCliente(Auth::user()->pi_cliente_id)
                                ->byEmpresa($request->empresa_id)
                                ->byNombre($request->nombre)
                                ->byCodigo($request->codigo)
                                ->byTipo($request->tipo)
                                ->byEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('unidades.index', compact('icono','header','empresas','estados','tipos','unidades'));
    }

    public function create()
    {
        $icono = self::ICONO;
        $header = self::CREATE;
        $empresas = Empresa::query()->byPiCliente(Auth::user()->pi_cliente_id)->pluck('nombre_comercial','id');
        $tipos = Unidad::TIPOS;
        return view('unidades.create', compact('icono','header','empresas','tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:unidades,nombre,null,id,empresa_id,' . $request->u_empresa_id,
            'codigo' => 'required|max:4|unique:unidades,codigo,null,id,empresa_id,' . $request->u_empresa_id,
            'tipo' => 'required'
        ]);
        try{
            $empresa = Empresa::find($request->u_empresa_id);
            $unidad = Unidad::create([
                'empresa_id' => $request->u_empresa_id,
                'pi_cliente_id' => $empresa->pi_cliente_id,
                'nombre' => $request->nombre,
                'codigo' => $request->codigo,
                'tipo' => $request->tipo,
                'estado' => '1'
                ]);

                if(isset($request->form_prod)){
                    return back()->with('success_message', 'Se agregó un unidad de medida correctamente.');;
                }
            return redirect()->route('unidades.index')->with('success_message', 'Se agregó un unidad de medida correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('unidades.create',$request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
