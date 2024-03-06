<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\TipoCambio;
use App\Models\Comprobante;
use Auth;
use PDF;

class TipoCambioController extends Controller
{
    const ICONO = 'fa-solid fa-circle-dollar-to-slot fa-fw';
    const INDEX = 'TIPO DE CAMBIOS';
    const CREATE = 'REGISTRAR TIPO DE CAMBIO';
    const EDITAR = 'MODIFICAR TIPO DE CAMBIO';

    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('tipo.cambio.index',Auth::user()->empresa_id);
        }
        return view('tipo_cambios.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($empresa_id);
        $estados = TipoCambio::ESTADOS;
        $tipo_cambios = TipoCambio::query()
                                ->byEmpresa($empresa_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('tipo_cambios.index', compact('icono','header','empresa','estados','tipo_cambios'));
    }

    public function search(Request $request)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($request->empresa_id);
        $estados = TipoCambio::ESTADOS;
        $tipo_cambios = TipoCambio::query()
                                ->byEmpresa($request->empresa_id)
                                ->byEntreFechas($request->fecha_i,$request->fecha_f)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('tipo_cambios.index', compact('icono','header','empresa','estados','tipo_cambios'));
        
    }

    public function create($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::CREATE;
        $empresa = Empresa::find($empresa_id);
        return view('tipo_cambios.create', compact('icono','header','empresa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
            'ufv' => 'required',
            'oficial' => 'required',
            'compra' => 'required',
            'venta' => 'required'
        ]);
        $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $tipo_cambio = TipoCambio::where('fecha',$fecha)->first();
        if($tipo_cambio != null){
            return redirect()->back()->with('info_message', 'Ya existe un tipo de cambio para la [FECHA] seleccionada...');
        }
        try{
            $empresa = Empresa::find($request->empresa_id);
            $datos = [
                'empresa_id' => $request->empresa_id,
                'cliente_id' => $empresa->cliente_id,
                'fecha' => $fecha,
                'ufv' => $request->ufv,
                'dolar_oficial' => $request->oficial,
                'dolar_compra' => $request->compra,
                'dolar_venta' => $request->venta,
                'estado' => '1'
            ];
            $cambio = TipoCambio::create($datos);

            return redirect()->route('tipo.cambio.index',['empresa_id' => $request->empresa_id])->with('success_message', 'Se agregó un tipo de cambio correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('tipo.cambio.create',$request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id)
    {
        $tipo_cambio = TipoCambio::find($id);
        $comprobantes = Comprobante::select('id')->where('fecha',$tipo_cambio->fecha)->whereIn('estado',['1','2'])->first();
        if($comprobantes != null){
            return redirect()->back()->with('info_message', '[ACCION NO PERMITIDA. EXISTEN COMPROBANTES PROCESADOS.]');
        }
        $icono = self::ICONO;
        $header = self::EDITAR;
        $empresa = Empresa::find($tipo_cambio->empresa_id);
        return view('tipo_cambios.editar', compact('tipo_cambio','icono','header','empresa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'ufv' => 'required',
            'oficial' => 'required',
            'compra' => 'required',
            'venta' => 'required'
        ]);
        try{
            $tipo_cambio = TipoCambio::find($request->tipo_cambio_id);
            $datos = [
                'ufv' => $request->ufv,
                'dolar_oficial' => $request->oficial,
                'dolar_compra' => $request->compra,
                'dolar_venta' => $request->venta
            ];
            $tipo_cambio->update($datos);

            return redirect()->route('tipo.cambio.index',['empresa_id' => $tipo_cambio->empresa_id])->with('info_message', 'La informacion fue actualizada.');
        } catch (ValidationException $e) {
            return redirect()->route('tipo.cambio.create',$tipo_cambio->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
