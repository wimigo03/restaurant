<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Zona;
use App\Models\Sucursal;
use App\Models\Mesa;
use App\Models\PrecioProducto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Validation\Rule;
use DataTables;
use Auth;
use DB;

class PedidoController extends Controller
{
    const ICONO = 'fas fa-utensils fa-fw';
    const INDEX = 'PEDIDOS';
    const REGISTRAR = 'REGISTRAR ORDEN';
    const EDITAR = 'MODIFICAR ORDEN';

    public function index()
    {dd("ok");
        $icono = self::ICONO;
        $header = self::REGISTRAR;
        $empresas = Empresa::query()
                                ->byPiCliente(Auth::user()->pi_cliente_id)
                                ->pluck('nombre_comercial','id');

        //return view('pedidos.index', compact('icono','header','empresas'));
    }

    public function create()
    {
        $icono = self::ICONO;
        $header = self::REGISTRAR;
        $empresas = Empresa::query()
                                ->byPiCliente(Auth::user()->pi_cliente_id)
                                ->pluck('nombre_comercial','id');

        return view('pedidos.create', compact('icono','header','empresas'));
    }

    public function getSucursalesByEmpresa(Request $request)
    {
        try{
            $input = $request->all();
            $id = $input['id'];
            $sucursales = Sucursal::query()
                                    ->byEmpresa($id)
                                    ->where('estado','1')
                                    ->get()
                                    ->toJson();
            if($sucursales){
                return response()->json([
                    'sucursales' => $sucursales
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getZonasBySucursales(Request $request)
    {
        try{
            $input = $request->all();
            $id = $input['id'];
            $zonas = Zona::where('sucursal_id', $id)->where('estado','1')->get();
            if($zonas){
                $zonasArray = $zonas->map(function ($zona) {
                    return [
                        'id' => $zona->id,
                        'nombre' => $zona->nombre
                    ];
                });

                return response()->json(['zonas' => $zonasArray]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDatosByZona(Request $request)
    {
        try{
            $input = $request->all();
            $id = $input['id'];
            $zona = Zona::find($id);
            if($zona != null){
                return response()->json([
                    'filas' => $zona->filas,
                    'columnas' => $zona->columnas
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMesas(Request $request)
    {
        try{
            $input = $request->all();
            $id = $input['id'];
            $mesas = Mesa::where('zona_id',$id)->where('estado','!=','5')->get();
            if(count($mesas) > 0){
                foreach($mesas as $mesa){
                    $mesa_id_array[] = $mesa->id;
                    $mesa_ocupada_array[] = $mesa->posicion;
                    $cantidad_sillas_array[] = $mesa->cantidad_sillas;
                    $titulo_array[] = $mesa->nombre;
                    $estado_array[] = $mesa->estado;
                }

                return response()->json([
                    'mesa_id_array' => $mesa_id_array,
                    'mesa_ocupada_array' => $mesa_ocupada_array,
                    'cantidad_sillas_array' => $cantidad_sillas_array,
                    'titulo_array' => $titulo_array,
                    'estado_array' => $estado_array
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDatosParaPedido(Request $request)
    {
        try{
            $input = $request->all();
            $mesa = Mesa::find($input['mesa_id']);
            $mesa->update([
                'estado' => '2'
            ]);
            $empresa_id = Mesa::select('empresa_id')->where('id',$input['mesa_id'])->first()->empresa_id;
            $productos_datos = PrecioProducto::where('empresa_id', $empresa_id)->where('tipo_precio_id',2)->where('precio','!=',0)->where('estado','1')->get();
            if(count($productos_datos) > 0){
                $productosDatosArray = $productos_datos->map(function ($datos) {
                    return [
                        'id' => $datos->id,
                        'precio' => $datos->precio,
                        'producto' => $datos->producto->nombre
                    ];
                });

                $pedido_en_proceso = Pedido::select('id')->where('mesa_id',$input['mesa_id'])->where('estado','1')->first();
                $importe_total = 0;
                $detallePedido = null;
                if($pedido_en_proceso != null){
                    $detalle_pedido = PedidoDetalle::where('pedido_id', $pedido_en_proceso->id)->where('estado','1')->get();
                    if(count($detalle_pedido) > 0){
                        foreach($detalle_pedido as $datos){
                            $importe_total = $importe_total + ($datos->cantidad * $datos->precio);
                        }
                        $detallePedido = $detalle_pedido->map(function ($detalle) {
                            return [
                                'pedido_detalle_id' => $detalle->id,
                                'categoria_master' => $detalle->categoria_master->nombre,
                                'producto' => $detalle->producto->codigo . ' ' . $detalle->producto->nombre,
                                'cantidad' => $detalle->cantidad,
                                'precio' => $detalle->precio,
                                'total' => $detalle->cantidad * $detalle->precio
                            ];
                        });
                    }
                }

                return response()->json([
                    'productos' => $productosDatosArray,
                    'nro_pedido' => $pedido_en_proceso != null ? $pedido_en_proceso->id : null,
                    'importe_total' => $importe_total,
                    'detallePedido' => $detallePedido,
                    'mesa' => $mesa->nombre
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUpdatePedido(Request $request)
    {
        try{
            $input = $request->all();
            $mesa = Mesa::find($input['mesa_id']);
            $anombrede = 'WILSON MARTINEZ OROPEZA';
            $cantidad_clientes = 0;
            $pedido_en_proceso = Pedido::select('id')->where('mesa_id',$mesa->id)->where('estado','1')->first();
            $precio_producto = PrecioProducto::find($input['precio_producto_id']);
            if($pedido_en_proceso == null){
                //NO HAY PEDIDO - CREAR PEDIDO
                $datos = [
                    'mesa_id' => $mesa->id,
                    'zona_id' => $mesa->zona_id,
                    'sucursal_id' => $mesa->sucursal_id,
                    'empresa_id' => $mesa->empresa_id,
                    'pi_cliente_id' => Auth::user()->pi_cliente_id,
                    'user_id' => Auth::user()->id,
                    'cargo_id' => Auth::user()->cargo_id,
                    'date_i' => date('Y-m-d H:i:s'),
                    'estado' => '1'
                ];
                $pedido = Pedido::create($datos);
            }else{
                $pedido = Pedido::find($pedido_en_proceso->id);
            }
            $datos_detalle = [
                'pedido_id' => $pedido->id,
                'mesa_id' => $pedido->mesa_id,
                'zona_id' => $pedido->zona_id,
                'sucursal_id' => $pedido->sucursal_id,
                'empresa_id' => $pedido->empresa_id,
                'pi_cliente_id' => Auth::user()->pi_cliente_id,
                'precio_producto_id' => $precio_producto->id,
                'producto_id' => $precio_producto->producto_id,
                'categoria_id' => $precio_producto->categoria_id,
                'unidad_id' => $precio_producto->unidad_id,
                'categoria_master_id' => $precio_producto->categoria_master_id,
                'moneda_id' => $precio_producto->moneda_id,
                'pais_id' => $precio_producto->pais_id,
                'tipo_precio_id' => $precio_producto->tipo_precio_id,
                'user_id' => Auth::user()->id,
                'cargo_id' => Auth::user()->cargo_id,
                'precio' => $precio_producto->precio,
                'estado' => '1'
            ];

            $pedido_detalle = PedidoDetalle::create($datos_detalle);

            $datos_importe_total = PedidoDetalle::where('pedido_id', $pedido->id)->where('estado','1')->get();
            $importe_total = 0;
            if(count($datos_importe_total) > 0){
                foreach($datos_importe_total as $datos){
                    $importe_total = $importe_total + ($datos->cantidad * $datos->precio);
                }
            }
            $detalle_pedido = PedidoDetalle::find($pedido_detalle->id);
            $detallePedido = [
                'pedido_detalle_id' => $detalle_pedido->id,
                'categoria_master' => $detalle_pedido->categoria_master->nombre,
                'producto' => $detalle_pedido->producto->codigo . ' ' . $detalle_pedido->producto->nombre,
                'precio' => $detalle_pedido->precio
            ];

            return response()->json([
                'nro_pedido' => $pedido->id,
                'importe_total' => $importe_total,
                'detallePedido' => $detallePedido
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function recuperarPedido($pedido_en_proceso_id)
    {
        //aqui falta completar el codigo
        $detalle_pedido = PedidoDetalle::where('pedido_id', $pedido_en_proceso_id)->where('estado','1')->get();
        $importe_total = $detalle_pedido->sum('precio');
        if(count($detalle_pedido) > 0){
            $detallePedido = $detalle_pedido->map(function ($detalle) {
                return [
                    'categoria_master' => $detalle->categoria_master->nombre,
                    'producto' => $detalle->producto->codigo . ' ' . $detalle->producto->nombre,
                    'precio' => $detalle->precio
                ];
            });

            return response()->json([
                'nro_pedido' => $pedido->id,
                'importe_total' => $importe_total,
                'detallePedido' => $detallePedido
            ]);
        }
    }

    public function store(Request $request)
    {
        $cont = 0;
        while($cont < count($request->pedido_detalle_id)){
            $pedido_detalle = PedidoDetalle::find($request->pedido_detalle_id[$cont]);
            $pedido_detalle->update([
                'cantidad' => $request->cantidad[$cont],
                'estado' => '2'
            ]);

            $cont++;
        }

        $detalles_pedido = PedidoDetalle::select('cantidad','precio')->where('estado','2')->get();

        $total = 0;

        foreach ($detalles_pedido as $detalle) {
            $total += $detalle->cantidad * $detalle->precio;
        }

        $pedido = Pedido::find($request->pedido_id);
        $pedido->update([
            'cantidad_clientes' => $request->cantidad_clientes,
            'date_f' => date('Y-m-d H:i:s'),
            'total' => $total,
            'estado' => '2'
        ]);

        $mesa = Mesa::find($pedido->mesa_id);
        $mesa->update([
            'estado' => '3'
        ]);

        return response()->json(['message' => 'Orden ejecutada.']);
    }

    public function pendiente(Request $request)
    {
        if(isset($request->pedido_detalle_id)){
            $cont = 0;
            while($cont < count($request->pedido_detalle_id)){
                $pedido_detalle = PedidoDetalle::find($request->pedido_detalle_id[$cont]);
                $pedido_detalle->update([
                    'cantidad' => $request->cantidad[$cont]
                ]);

                $cont++;
            }

            $detalles_pedido = PedidoDetalle::select('cantidad','precio')->where('estado','1')->get();

            $total = 0;

            foreach ($detalles_pedido as $detalle) {
                $total += $detalle->cantidad * $detalle->precio;
            }

            $pedido = Pedido::find($request->pedido_id);
            $pedido->update([
                'cantidad_clientes' => $request->cantidad_clientes,
                'total' => $total
            ]);
        }

        $mesa = Mesa::find($request->mesa_id);
        $mesa->update([
            'estado' => '2'
        ]);

        return response()->json(['message' => 'Orden ejecutada.']);
    }

    public function anular(Request $request)
    {
        if(isset($request->pedido_detalle_id)){
            $cont = 0;
            while($cont < count($request->pedido_detalle_id)){
                $pedido_detalle = PedidoDetalle::find($request->pedido_detalle_id[$cont]);
                $pedido_detalle->update([
                    'cantidad' => $request->cantidad[$cont]
                ]);

                $cont++;
            }

            $detalles_pedido = PedidoDetalle::select('cantidad','precio')->where('estado','1')->get();

            $total = 0;

            foreach ($detalles_pedido as $detalle) {
                $total += $detalle->cantidad * $detalle->precio;
            }

            $pedido = Pedido::find($request->pedido_id);
            $pedido->update([
                'cantidad_clientes' => $request->cantidad_clientes,
                'total' => $total,
                'estado' => '3'
            ]);
        }

        $mesa = Mesa::find($request->mesa_id);
        $mesa->update([
            'estado' => '1'
        ]);

        return response()->json(['message' => 'Orden ejecutada.']);
    }
}
