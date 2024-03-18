<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Models\Empresa;
use App\Models\BalanceApertura;
use App\Models\InicioMesFiscal;
use App\Models\Comprobante;
use App\Models\ComprobanteDetalle;
use App\Models\ComprobanteF;
use App\Models\ComprobanteFDetalle;
use App\Models\Sucursal;
use App\Models\PlanCuenta;
use App\Models\PlanCuentaAuxiliar;
use App\Models\User;
use DB;

class BalanceAperturaController extends Controller
{
    const ICONO = 'fa-solid fa-tag fa-fw';
    const INDEX = 'BALANCE DE APERTURA';
    const CREATE = 'REGISTRAR BALANCE';
    const EDITAR = 'MODIFICAR BALANCE';
    const MODIFICAR_COMPROBANTE = 'MODIFICAR COMPROBANTE';

    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('balance.apertura.index',Auth::user()->empresa_id);
        }
        return view('balance_apertura.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresa = Empresa::find($empresa_id);
        $balances = BalanceApertura::query()
                                    ->byEmpresa($empresa_id)
                                    ->orderBy('id','desc')
                                    ->paginate(10);
        return view('balance_apertura.index', compact('icono','header','empresa','balances'));
    }

    public function search(Request $request)
    {
        $fecha = date('Y-m-d');
        $tipo_cambio = TipoCambio::where('fecha',$fecha)->first();
        if($tipo_cambio == null){
            return redirect()->back()->with('info_message', 'No existe un tipo de cambio para la [FECHA] seleccionada...');
        }
        $icono = self::ICONO;
        $header = self::INDEX;
        $tipo_precios = TipoPrecio::pluck('nombre','id');
        $tipo_movimientos = PrecioProducto::TIPO_MOVIMIENTOS;
        $estados = PrecioProducto::ESTADOS;
        $empresa = Empresa::find($request->empresa_id);
        $precio_productos = PrecioProducto::query()
                        ->byEmpresa($empresa->id)
                        ->byTipoPrecio($request->tipo_precio_id)
                        ->byCodigo($request->codigo)
                        ->byProducto($request->producto)
                        ->byEstado(1)
                        ->orderBy('id','desc')
                        ->get();
        return view('precio_productos.index', compact('tipo_cambio','icono','header','estados','tipo_precios','tipo_movimientos','empresa','precio_productos'));
    }

    public function create($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::CREATE;
        $empresa = Empresa::find($empresa_id);
        $anho = date('Y');
        for($i = $anho-1; $i <= $anho+2; $i++){
            $anhos[$i] = $i;
        }
        return view('balance_apertura.create', compact('icono','header','empresa','anhos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anho' => 'required'
        ]);
        $inicioMesFiscal = InicioMesFiscal::where('empresa_id',$request->empresa_id)->where('estado','1')->orderBy('id','desc')->first();
        if($inicioMesFiscal == null){
            return redirect()->back()->with('info_message', '[FALTA CONFIGURACION DE INICIO DE GESTION]');
        }

        $balanceApertura = BalanceApertura::where('gestion',$request->anho)->first();
        if($balanceApertura != null){
            return redirect()->back()->with('error_message','[ERROR EN OPERACION. YA EXISTE UN COMPROBANTE PARA EL BALANCE DE APERTURA EN LA GESTION SELECCIONADA]')->withInput();
        }

        $date = $request->anho . '-' . $inicioMesFiscal->mes . '-' . $inicioMesFiscal->dia;
        $comprobante_controller = new ComprobanteController;
        $comprobante = $comprobante_controller->primerComprobanteMes('3',$request->empresa_id,$date);
        if($comprobante != null){
            return redirect()->back()->with('error_message','[ERROR EN OPERACION. EL COMPROBANTE NRO 1 YA EXISTE EN LA GESTION Y CONFIGURACON SELECCIONADA (I)]')->withInput();
        }

        $comprobantef_controller = new ComprobanteFController;
        $comprobantef = $comprobantef_controller->primerComprobanteMes('3',$request->empresa_id,$date);
        if($comprobantef != null){
            return redirect()->back()->with('error_message','[ERROR EN OPERACION. EL COMPROBANTE NRO 1 YA EXISTE EN LA GESTION Y CONFIGURACON SELECCIONADA (F)]')->withInput();
        }

        $user = User::find(Auth::user()->id);

        $date =  $inicioMesFiscal->dia . '/' . $inicioMesFiscal->mes . '/' . $request->anho;

        $datos_comprobante = [
            'user_id' => $user->id,
            'copia' => 'on',
            'moneda_id' => 2,
            'empresa_id' => $request->empresa_id,
            'fecha_comprobante' => $date,
            'tipo' => '3',
            'entregado_recibido' => null,
            'concepto' => 'BALANCE DE APERTURA',
            'monto_total' => 0.00
        ];

        $comprobante = $comprobante_controller->crearEncabezadoComprobante($datos_comprobante);
        $comprobante_f = ComprobanteF::where('comprobante_id',$comprobante->id)->first();
        
        $empresa = Empresa::find($request->empresa_id);

        $datos_balance_apertura = [
            'empresa_id' => $empresa->id,
            'cliente_id' => $empresa->cliente_id,
            'user_id' => $user->id,
            'cargo_id' => $user->cargo_id,
            'comprobante_id' => $comprobante->id,
            'tipo_cambio_id' => $comprobante->tipo_cambio_id,
            'gestion' => $request->anho,
            'base' => '1',
            'estado' => '1'
        ];

        $datos_balance_apertura_f = [
            'empresa_id' => $empresa->id,
            'cliente_id' => $empresa->cliente_id,
            'user_id' => $user->id,
            'cargo_id' => $user->cargo_id,
            'comprobante_id' => $comprobante_f->id,
            'tipo_cambio_id' => $comprobante_f->tipo_cambio_id,
            'gestion' => $request->anho,
            'base' => '2',
            'estado' => '1'
        ];

        $balance_apertura = BalanceApertura::create($datos_balance_apertura);
        $balance_apertura_f = BalanceApertura::create($datos_balance_apertura_f);

        return redirect()->route('balance.apertura.index',['empresa_id' => $request->empresa_id])->with('success_message', '[BALANCE DE APERTURA CREADO]');
    }

    public function show($producto_id)
    {
        dd($producto_id);
    }

    public function editarb1($comprobante_id)
    {
    }

    public function editarb2($comprobante_id)
    {
    }

    public function update(Request $request)
    {
    }

    public function habilitar($id)
    {
    }

    public function deshabilitar($id)
    {
    }
}
