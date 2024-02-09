<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\TipoPrecio;
use App\Models\PrecioVenta;

class PrecioVentaController extends Controller
{
    const ICONO = 'fa-solid fa-tag fa-fw';
    const INDEX = 'PRECIOS VENTA';
    const REGISTRAR = 'REGISTRAR PRECIO VENTA';
    const EDITAR = 'MODIFICAR PRECIO VENTA';

    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('precio.ventas.index',Auth::user()->empresa_id);
        }
        return view('precio_ventas.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $tipos = TipoPrecio::pluck('nombre','id');
        $estados = PrecioVenta::ESTADOS;
        $empresa = Empresa::find($empresa_id);
        $precios = PrecioVenta::query()
                        ->byEmpresa($empresa_id)
                        ->orderBy('id','desc')
                        ->paginate(10);
        return view('precio_ventas.index', compact('icono','header','estados','tipos','empresa','precios'));
    }

    public function search(Request $request)
    {dd("okoko");
        $icono = self::ICONO;
        $header = self::INDEX;
        $sucursales = Sucursal::where('empresa_id',$request->empresa_id)->pluck('nombre','id');
        $estados = Zona::ESTADOS;
        $empresa = Empresa::find($request->empresa_id);
        $mesas = Mesa::query()
                        ->byEmpresa($request->empresa_id)
                        ->bySucursal($request->sucursal_id)
                        ->byZona($request->zona_id)
                        ->byNumero($request->numero)
                        ->bySillas($request->sillas)
                        ->byDetalle($request->detalle)
                        ->byEstado($request->estado)
                        ->orderBy('id','desc')
                        ->paginate(10);
        return view('mesas.index', compact('icono','header','sucursales','estados','empresa','mesas'));
    }

    public function create($empresa_id,$tipo_precio_id)
    {//dd($empresa_id,$tipo_precio_id);
        $icono = self::ICONO;
        $header = self::REGISTRAR;
        $empresa = Empresa::find($empresa_id);
        $tipos_precio = TipoPrecio::pluck('nombre','id');
        $productos = Producto::query()
                                ->byEmpresa($empresa_id)
                                ->byTipoPrecio($tipo_precio_id)
                                ->get();
        return view('precio_ventas.create', compact('icono','header','empresa','tipos_precio','productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'empresa_id' => 'required',
            'tipo_precio_id' => 'required'
        ]);
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $cont = 0;
            while($cont < count($request->producto_id)){
                $datos = [
                    'producto_id' => $request->producto_id[$cont],
                    'empresa_id' => $request->empresa_id,
                    'cliente_id' => $request->cliente_id,
                    'categoria_id' => $request->categoria_id[$cont],
                    'categoria_master_id' => $request->categoria_master_id[$cont],
                    'plan_cuenta_id' => $request->plan_cuenta_id[$cont],
                    'unidad_id' => $request->unidad_id[$cont],
                    'moneda_id' => $request->moneda_id[$cont],
                    'pais_id' => $request->pais_id[$cont],
                    'tipo_precio_id' => $request->tipo_precio_id,
                    'costo' => $request->precio[$cont],
                    'p_descuento' => $request->descuento[$cont],
                    'costo_final' => $request->precio_final[$cont],
                    'estado' => '1'
                ];

                $precio_venta = PrecioVenta::create($datos);
                $cont++;
            }

            return redirect()->route('precio.ventas.index', ['empresa_id' => $request->empresa_id])->with('success_message', 'Se agregó una [PRECIOS] a los productos seleccionados.');
        } catch (ValidationException $e) {
            return redirect()->route('precio.ventas.create', $request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function editar($id)
    {
        $mesa = Mesa::find($id);
        $icono = self::ICONO;
        $header = self::EDITAR;
        $sucursales = Sucursal::where('empresa_id',$mesa->empresa_id)->where('estado','1')->get();
        $empresa = Empresa::find($mesa->empresa_id);
        return view('mesas.editar', compact('mesa','icono','header','sucursales','empresa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required',
            'zona_id' => 'required',
            'numero' => [
                'required',
                Rule::unique('mesas')->where(function ($query) use ($request) {
                    return $query->where('sucursal_id', $request->sucursal_id)
                                 ->where('zona_id', $request->zona_id)
                                 ->whereNotIn('id', [$request->mesa_id]);;
                }),
            ],
            'sillas' => 'required'
        ]);
        try{
            $mesa = Mesa::find($request->mesa_id);
            $datos = [
                'zona_id' => $request->zona_id,
                'sucursal_id' => $request->sucursal_id,
                'numero' => $request->numero,
                'sillas' => $request->sillas,
                'detalle' => $request->detalle
            ];

            $mesa->update($datos);

            return redirect()->route('mesas.index', ['empresa_id' => $request->empresa_id])->with('success_message', 'Se Modificó una [MESA] en la sucursal seleccionada.');
        } catch (ValidationException $e) {
            return redirect()->route('mesas.editar', $request->mesa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function habilitar($id)
    {
        try{
            $mesa = Mesa::find($id);
            $mesa->update([
                'estado' => '1'
            ]);

            $zona = Zona::find($mesa->zona_id);
            $zona->update([
                'mesas_disponibles' => $zona->mesas_disponibles + 1
            ]);
            return redirect()->route('mesas.index',$mesa->empresa_id)->with('info_message', 'Se Habilito una [MESA] seleccionada...');
        } catch (ValidationException $e) {
            return redirect()->route('mesas.index',$mesa->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function deshabilitar($id)
    {
        try{
            $mesa = Mesa::find($id);
            $mesa->update([
                'estado' => '2'
            ]);

            $zona = Zona::find($mesa->zona_id);
            $zona->update([
                'mesas_disponibles' => $zona->mesas_disponibles - 1
            ]);
            return redirect()->route('mesas.index',$mesa->empresa_id)->with('info_message', 'Se Deshabilito una [MESA] seleccionada...');
        } catch (ValidationException $e) {
            return redirect()->route('mesas.index',$mesa->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
