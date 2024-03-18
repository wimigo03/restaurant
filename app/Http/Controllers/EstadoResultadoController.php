<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Models\Empresa;
use App\Models\Comprobante;
use App\Models\ComprobanteDetalle;
use App\Models\PlanCuenta;
use App\Models\User;
use DB;

class EstadoResultadoController extends Controller
{
    const ICONO = 'fa-solid fa-tag fa-fw';
    const INDEX = 'ESTADO DE RESULTADO';

    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('estado.resultado.index',Auth::user()->empresa_id);
        }
        return view('estado_resultado.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($empresa_id);
        return view('estado_resultado.index', compact('icono','header','empresa'));
    }

    public function search(Request $request)
    {//dd($request->all());
        $request->validate([
            'fecha_i' => 'required',
            'fecha_f' => 'required'
        ]);

        $icono = self::ICONO;
        $header = self::INDEX;
        $fecha_i = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_i)));
        $fecha_f = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_f)));
        if($fecha_i > $fecha_f){
            return redirect()->back()->with('info_message', '[LA FECHA INICIAL NO PUEDE SER MAYOY A LA FECHA FINAL]');
        }

        if($request->estado == '_todos_'){
            $status = ['1','2'];
        }else{
            $status = $request->estado;
        }
        $empresa = Empresa::find($request->empresa_id);

        $ingresos = PlanCuenta::where('codigo','like','4%')
                                ->where('empresa_id',$empresa->id)
                                ->whereIn('estado',$status)
                                ->get();
        $ingresos = PlanCuenta::orderByCodigo($ingresos);

        $costos = PlanCuenta::where('codigo','like','5%')
                                ->where('empresa_id',$empresa->id)
                                ->whereIn('estado',$status)
                                ->get();
        $costos = PlanCuenta::orderByCodigo($costos);

        $gastos = PlanCuenta::where('codigo','like','6%')
                                ->where('empresa_id',$empresa->id)
                                ->whereIn('estado',$status)
                                ->get();
        $gastos = PlanCuenta::orderByCodigo($gastos);

        $totales = [];
        $cuentas = array();
        $tipoOperacion = "-+";
        $planCuentaId = $ingresos[0]->id;
        $totales[$planCuentaId] = $this->sum_total_account_gestion($planCuentaId,$fecha_i,$fecha_f,$status,$empresa->id,$tipoOperacion,$totales,$cuentas);
        $tipoOperacion = "+-";
        $planCuentaId = $costos[0]->id;
        $totales[$planCuentaId] = $this->sum_total_account_gestion($planCuentaId,$fecha_i,$fecha_f,$status,$empresa->id,$tipoOperacion,$totales,$cuentas);
        $planCuentaId = $gastos[0]->id;
        $totales[$planCuentaId] = $this->sum_total_account_gestion($planCuentaId,$fecha_i,$fecha_f,$status,$empresa->id,$tipoOperacion,$totales,$cuentas);
//dd($totales);
        $nroMaxColumna = 5;
        $total = $totales[$ingresos[0]->id] - $totales[$costos[0]->id] - $totales[$gastos[0]->id];
        
        return view('estado_resultado.index', compact('icono','header','empresa','ingresos','costos','gastos','nroMaxColumna','total','totales'));
    }

    public function sum_total_account_gestion($plan_cuenta_id,$start_date,$end_date,$status,$empresa_id,$tipoOperacion, &$totales, &$cuentas){dd($status);
        $totalFinal = 0;
        $planCuenta = PlanCuenta::find($plan_cuenta_id);
        if($planCuenta->detalle == '1'){
            $comprobantes = ComprobanteDetalle::join('comprobantes as c','c.id','comprobante_detalles.comprobante_id')
                                                    ->where('comprobante_detalles.plan_cuenta_id',$plan_cuenta_id)
                                                    ->whereBetween('c.fecha',[$start_date,$end_date])
                                                    ->where('c.empresa_id',$empresa_id)
                                                    ->whereIn('c.estado',$status)
                                                    //->orderBy('comprobante_detalles.plan_cuenta_auxiliar_id')
                                                    //->orderBy('c.fecha')
                                                    ->select('c.id',
                                                                'c.fecha',
                                                                'comprobante_detalles.plan_cuenta_id',
                                                                'c.nro_comprobante',
                                                                'comprobante_detalles.glosa',
                                                                'comprobante_detalles.debe',
                                                                'comprobante_detalles.haber',
                                                                'comprobante_detalles.plan_cuenta_id',
                                                                'comprobante_detalles.nro_cheque',
                                                                'comprobante_detalles.orden_cheque',
                                                                'c.estado',
                                                                'comprobante_detalles.plan_cuenta_auxiliar_id as cuentaAux')
                                                    ->get();
            $total = 0;
            foreach ($comprobantes as $comp) {
                if($tipoOperacion == "-+"){
                    $total += $comp->haber;
                    $total -= $comp->debe;
                }else{
                    $total += $comp->debe;
                    $total -= $comp->haber;
                }
            }
            $totalFinal += $total;
            if(!in_array($planCuenta->id,$cuentas)){
                $totales[$planCuenta->id] = $totalFinal;
                array_push($cuentas,$planCuenta->id);
            }
        }else{
            $childs = PlanCuenta::where('parent_id',$planCuenta->id)->get();
            foreach ($childs as $child ) {
                $totalFinalActual = $this->sum_total_account_gestion($child->id,$start_date,$end_date,$status,$empresa_id,$tipoOperacion,$totales,$cuentas);
                $totalFinal += $totalFinalActual;
                if(!in_array($child->id,$cuentas)){
                    $totales[$child->id] = $totalFinalActual;
                    array_push($cuentas,$child->id);
                }
            }
        }
        return $totalFinal;
    }
}
