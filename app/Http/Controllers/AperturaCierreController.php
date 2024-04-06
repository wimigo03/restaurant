<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AperturaCierre;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Cargo;
use DB;
use Auth;
use Illuminate\Support\Facades\Log;

class AperturaCierreController extends Controller
{
    const ICONO = 'fa-solid fa-file-invoice-dollar fa-fw';
    const INDEX = 'APERTURA Y CIERRES DE CAJA';
    const CREATE = 'REGISTRAR APERTURA Y CIERRE DE CAJA';
    const EDITAR = 'MODIFICAR APERTURA Y CIERRES DE CAJA';

    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('apertura.cierre.index',Auth::user()->empresa_id);
        }
        return view('apertura_cierre.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($empresa_id);
        $users = User::select(DB::raw('concat(username," - ",name) as usuario'),'id')
                                        ->where('estado','1')
                                        ->where('empresa_id',$empresa_id)
                                        ->pluck('usuario','id');
        $cargos = Cargo::where('empresa_id',$empresa_id)->where('estado','1')->pluck('nombre','id');
        $estados = AperturaCierre::ESTADOS;
        $aperturas_cierres = AperturaCierre::query()
                                            ->byEmpresa($empresa_id)
                                            ->orderBy('id','desc')
                                            ->paginate(10);
        return view('apertura_cierre.index', compact('icono','header','empresa','users','cargos','estados','aperturas_cierres'));
    }

    public function search(Request $request)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($request->empresa_id);
        $users = User::select(DB::raw('concat(username," - ",name) as usuario'),'id')
                                        ->where('estado','1')
                                        ->where('empresa_id',$request->empresa_id)
                                        ->pluck('usuario','id');
        $cargos = Cargo::where('empresa_id',$request->empresa_id)->where('estado','1')->pluck('nombre','id');
        $estados = AperturaCierre::ESTADOS;
        $aperturas_cierres = AperturaCierre::query()
                                            ->byEmpresa($request->empresa_id)
                                            ->byCodigo($request->codigo)
                                            ->byUser($request->user_id)
                                            ->byCargo($request->cargo_id)
                                            ->byMonto($request->monto)
                                            ->byFechaInicio($request->fecha_inicio)
                                            ->byFechaCierre($request->fecha_cierre)
                                            ->byEstado($request->estado)
                                            ->orderBy('id','desc')
                                            ->paginate(10);
        return view('apertura_cierre.index', compact('icono','header','empresa','users','cargos','estados','aperturas_cierres'));
    }

    public function create($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::CREATE;
        $empresa = Empresa::find($empresa_id);
        $users = User::select(DB::raw('concat(username," - ",name) as usuario'),'id')
                                        ->where('estado','1')
                                        ->where('empresa_id',$empresa_id)
                                        ->pluck('usuario','id');
        return view('apertura_cierre.create', compact('icono','header','empresa','users'));
    }

    public function store(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $apertura_cierre = DB::transaction(function () use ($request) {
                $date_inicial = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_inicial)));
                $date = date('Y-m-d');
                $empresa = Empresa::find($request->empresa_id);
                $user = User::find($request->user_id);
                $aperturas_cierres = AperturaCierre::where('empresa_id',$request->empresa_id)->get()->count();
                $gestion = substr(date('Y', strtotime($date)), -2);
                $numero = $aperturas_cierres + 1;
                $codigo = $empresa->alias . '-' . $gestion . '-' . (str_pad($numero,3,"0",STR_PAD_LEFT));
                $datos = [
                    'user_id' => $user->id,
                    'cargo_id' => $user != null ? $user->id : null,
                    'empresa_id' => $empresa->id,
                    'cliente_id' => $empresa->cliente_id,
                    'codigo' => $codigo,
                    'fecha_inicial' => $date_inicial,
                    'monto_apertura' => floatval(str_replace(",", "", $request->monto)),
                    'observaciones' => $request->observaciones,
                    'estado' => '1',
                ];
                $apertura_cierre = AperturaCierre::create($datos);

                return $apertura_cierre;
            });
            Log::channel('aperturas_cierres')->info(
                "\n" .
                "Mensaje: Apertura Cierre creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('apertura.cierre.index',['empresa_id' => $request->empresa_id])->with('success_message', 'Se creo un registro con exito.');
        } catch (\Exception $e) {
            Log::channel('aperturas_cierres')->info(
                "\n" .
                "Mensaje: Error al crear registro de apertura: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear registro de apertura]')->withInput();
        } finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function editar($asiento_automatico_id)
    {
        $icono = self::ICONO;
        $header = self::EDITAR;
        $asiento_automatico = AsientoAutomatico::find($asiento_automatico_id);
        $empresa = Empresa::find($asiento_automatico->empresa_id);
        $plan_cuentas = PlanCuenta::select(DB::raw('concat(codigo," ",nombre) as cuenta_contable'),'id')
                                    ->where('detalle','1')
                                    ->where('estado','1')
                                    ->where('empresa_id',$asiento_automatico->empresa_id)
                                    ->get();
        $monedas = Moneda::where('estado','1')->orderBy('id','desc')->get();
        $modulos = Modulo::where('estado','1')->where('id','!=','3')->get();
        $tipos = AsientoAutomatico::TIPOS;
        return view('asientos_automaticos.editar', compact('icono','header','asiento_automatico','empresa','plan_cuentas','monedas','modulos','tipos'));
    }

    public function update(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $asiento_automatico = DB::transaction(function () use ($request) {
                $asiento_automatico = AsientoAutomatico::find($request->asiento_automatico_id);
                $empresa = Empresa::find($asiento_automatico->empresa_id);
                $moneda = Moneda::where('id',$asiento_automatico->moneda_id)->first();
                $copia = isset($request->copia) ? '1' : '2';
                $datos = [
                    'empresa_id' => $empresa->id,
                    'cliente_id' => $empresa->cliente_id,
                    'modulo_id' => $request->modulo_id,
                    'plan_cuenta_id' => $request->plan_cuenta_id,
                    'moneda_id' => $moneda->id,
                    'pais_id' => $moneda->pais_id,
                    'nombre' => $request->nombre,
                    'concepto' => $request->concepto,
                    'tipo' => $request->tipo,
                    'glosa' => $request->glosa,
                    'copia' => $copia
                ];
                $asiento_automatico->update($datos);

                return $asiento_automatico;
            });
            Log::channel('asientos_automaticos')->info(
                "\n" .
                "Mensaje: Asiento automatico creado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('asiento.automatico.index',['empresa_id' => $request->empresa_id])->with('success_message', 'Se modifico un asiento automatico con exito.');
        } catch (\Exception $e) {
            Log::channel('asientos_automaticos')->info(
                "\n" .
                "Mensaje: Error al modificar asiento automatico: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el asiento automatico]')->withInput();
        } finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function habilitar($asiento_automatico_id)
    {
        try{
            $asiento_automatico = AsientoAutomatico::find($asiento_automatico_id);
            $asiento_automatico->update([
                'estado' => '1'
            ]);

            Log::channel('asientos_automaticos')->info(
                "\n" .
                "Mensaje: Asiento automatico habilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('asiento.automatico.index',['empresa_id' => $asiento_automatico->empresa_id])->with('success_message', 'Se habilito un asiento automatico con exito.');
        } catch (\Exception $e) {
            Log::channel('asientos_automaticos')->info(
                "\n" .
                "Mensaje: Error al habilitar asiento automatico: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar el asiento automatico]')->withInput();
        }
    }

    public function deshabilitar($asiento_automatico_id)
    {
        try{
            $asiento_automatico = AsientoAutomatico::find($asiento_automatico_id);
            $asiento_automatico->update([
                'estado' => '2'
            ]);

            Log::channel('asientos_automaticos')->info(
                "\n" .
                "Mensaje: Asiento automatico deshabilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('asiento.automatico.index',['empresa_id' => $asiento_automatico->empresa_id])->with('success_message', 'Se deshabilito un asiento automatico con exito.');
        } catch (\Exception $e) {
            Log::channel('asientos_automaticos')->info(
                "\n" .
                "Mensaje: Error al deshabilitar asiento automatico: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar el asiento automatico]')->withInput();
        }
    }
}
