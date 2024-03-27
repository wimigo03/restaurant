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
use App\Models\InicioMesFiscal;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\LibroMayorCuentaGeneralFExcel;
use DB;
use PDF;

class LibroMayorCuentaGeneralFController extends Controller
{
    const ICONO = 'fa-solid fa-tag fa-fw';
    const INDEX = 'LIBRO MAYOR POR CUENTA GENERAL';

    public function index($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($empresa_id);
        $plan_cuentas = PlanCuenta::select(DB::raw('concat(codigo," ",nombre) as cuenta_contable'),'id')->where('detalle','1')->where('estado','1')->pluck('cuenta_contable','id');
        return view('libro_mayor_cuenta_general_f.index', compact('icono','header','empresa','plan_cuentas'));
    }

    public function search(Request $request)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa_id = $request->empresa_id;
        $fecha_i = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_i)));
        $fecha_f = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_f)));
        $plan_cuenta_id = $request->plan_cuenta_id;

        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $libro_mayor_cuenta_general = $this->procesarLibroMayorCuentaGeneral($empresa_id,$fecha_i,$fecha_f,$plan_cuenta_id);
                $comprobantes = $libro_mayor_cuenta_general['comprobantes'];
                $saldo = $libro_mayor_cuenta_general['saldo'];
                $saldo_final = $libro_mayor_cuenta_general['saldo_final'];
                $empresa = $libro_mayor_cuenta_general['empresa'];
                $plan_cuenta = $libro_mayor_cuenta_general['plan_cuenta'];
                $total_debe = $libro_mayor_cuenta_general['total_debe'];
                $total_haber = $libro_mayor_cuenta_general['total_haber'];
                return view('libro_mayor_cuenta_general_f.index', compact('icono','header','empresa','fecha_i','fecha_f','plan_cuenta','comprobantes','saldo','saldo_final','total_debe','total_haber'));
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function procesarLibroMayorCuentaGeneral($empresa_id,$fecha_i,$fecha_f,$plan_cuenta_id){
        $comprobantes = DB::table('comprobantef_detalles as a')
                                ->join('comprobantesf as b','b.id','a.comprobantef_id')
                                ->join('sucursales as c','c.id','a.sucursal_id')
                                ->leftjoin('plan_cuentas_auxiliares as d','d.id','a.plan_cuenta_auxiliar_id')
                                ->where('a.plan_cuenta_id',$plan_cuenta_id)
                                ->whereBetween('b.fecha',[$fecha_i,$fecha_f])
                                ->where('b.empresa_id',$empresa_id)
                                ->where('a.estado','1')
                                ->select(
                                        'a.id',
                                        DB::raw("DATE_FORMAT(b.fecha,'%d/%m/%Y') as fecha"),
                                        'b.nro_comprobante',
                                        DB::raw("CASE
                                            WHEN b.estado = 1 THEN 'BORRADOR'
                                            WHEN b.estado = 2 THEN 'APROBADO'
                                            ELSE 'N/A'
                                        END AS estado"),
                                        DB::raw("CASE
                                            WHEN b.estado = 1 THEN 'B'
                                            WHEN b.estado = 2 THEN 'A'
                                            ELSE 'N/A'
                                        END AS estado_abreviado"),
                                        'c.nombre as proyecto',
                                        DB::raw("if(isnull(a.plan_cuenta_auxiliar_id),'',d.nombre) as auxiliar"),
                                        'a.nro_cheque',
                                        'a.glosa',
                                        'a.debe',
                                        'a.haber')
                                ->get();

        $plan_cuenta = PlanCuenta::find($plan_cuenta_id);
        $empresa = Empresa::find($empresa_id);
        $saldo = $this->obtenerSaldoPorCuenta($fecha_i, $plan_cuenta_id, $empresa_id);
        $saldo_final = $saldo;
        $total_debe = $comprobantes->sum('debe');
        $total_haber = $comprobantes->sum('haber');
        $saldo_final += $total_debe - $total_haber;
        return [
            'comprobantes' => $comprobantes,
            'saldo' => $saldo,
            'saldo_final' => $saldo_final,
            'empresa' => $empresa,
            'plan_cuenta' => $plan_cuenta,
            'total_debe' => $total_debe,
            'total_haber' => $total_haber,
        ];
    }

    public function obtenerSaldoPorCuenta($fecha_i, $plan_cuenta_id, $empresa_id){
        $saldo = 0;
        $inicio_mes_fiscal = InicioMesFiscal::select('dia','mes')->where('empresa_id',$empresa_id)->where('estado','1')->first();
        $anho = date("Y", strtotime($fecha_i));
        $mes = $inicio_mes_fiscal->mes;
        $dia = $inicio_mes_fiscal->dia;
        $inicio_gestion = $anho . '-' . $mes .'-'. $dia . ' 00:00:00';
        $fecha_final = date('Y-m-d 23:59:59', strtotime($fecha_i) - 86400);
        if($fecha_final <= $inicio_gestion){
            $fecha_inicial = ($anho - 1) . '-' . $mes . '-' . $dia . ' 00:00:00';
        }else{
            $fecha_inicial = $anho . '-' . $mes . '-' . $dia . ' 00:00:00';
        }
        $sumar_restar = DB::table('comprobantef_detalles as a')
                                ->join('comprobantesf as b','b.id','a.comprobantef_id')
                                ->where('a.plan_cuenta_id',$plan_cuenta_id)
                                ->whereBetween('b.fecha',[$fecha_inicial,$fecha_final])
                                ->where('b.empresa_id',$empresa_id)
                                ->where('a.estado','1')
                                //->where('b.estado','2')
                                ->select('a.debe','a.haber')
                                ->get();
        $saldo = $sumar_restar->sum('debe') - $sumar_restar->sum('haber');
        return $saldo;
    }
    public function excel(Request $request)
    {
        $empresa_id = $request->empresa_id;
        $fecha_i = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_i)));
        $fecha_f = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_f)));
        $plan_cuenta_id = $request->plan_cuenta_id;

        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $libro_mayor_cuenta_general = $this->procesarLibroMayorCuentaGeneral($empresa_id,$fecha_i,$fecha_f,$plan_cuenta_id);
                $comprobantes = $libro_mayor_cuenta_general['comprobantes'];
                $saldo = $libro_mayor_cuenta_general['saldo'];
                $saldo_final = $libro_mayor_cuenta_general['saldo_final'];
                $empresa = $libro_mayor_cuenta_general['empresa'];
                $plan_cuenta = $libro_mayor_cuenta_general['plan_cuenta'];
                $total_debe = $libro_mayor_cuenta_general['total_debe'];
                $total_haber = $libro_mayor_cuenta_general['total_haber'];
                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;
            return Excel::download(new LibroMayorCuentaGeneralFExcel($libro_mayor_cuenta_general,$comprobantes,$fecha_i,$fecha_f,$saldo,$saldo_final,$empresa,$plan_cuenta,$total_debe,$total_haber),'Libro_Mayor_Cuenta_general.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function pdf(Request $request)
    {
        $empresa_id = $request->empresa_id;
        $fecha_i = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_i)));
        $fecha_f = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_f)));
        $plan_cuenta_id = $request->plan_cuenta_id;

        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $libro_mayor_cuenta_general = $this->procesarLibroMayorCuentaGeneral($empresa_id,$fecha_i,$fecha_f,$plan_cuenta_id);
                $comprobantes = $libro_mayor_cuenta_general['comprobantes'];
                $saldo = $libro_mayor_cuenta_general['saldo'];
                $saldo_final = $libro_mayor_cuenta_general['saldo_final'];
                $empresa = $libro_mayor_cuenta_general['empresa'];
                $plan_cuenta = $libro_mayor_cuenta_general['plan_cuenta'];
                $total_debe = $libro_mayor_cuenta_general['total_debe'];
                $total_haber = $libro_mayor_cuenta_general['total_haber'];
                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;
                $pdf = PDF::loadView('libro_mayor_cuenta_general_f.pdf',compact(['libro_mayor_cuenta_general','comprobantes','fecha_i','fecha_f','saldo','saldo_final','empresa','plan_cuenta','total_debe','total_haber']));
                $pdf->setPaper('LETTER', 'portrait');
                return $pdf->download('Libro_Mayor_Cuenta_General.pdf');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
