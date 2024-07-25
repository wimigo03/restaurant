<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Zona;
use App\Models\Sucursal;
use App\Models\Mesa;
use Illuminate\Validation\Rule;
use DataTables;
use Auth;
use DB;

class MesaController extends Controller
{
    const ICONO = 'fas fa-utensils fa-fw';
    const INDEX = 'MESAS';
    const REGISTRAR = 'REGISTRAR MESA';
    const EDITAR = 'MODIFICAR MESA';
    const SETTING = 'CONFIGURAR MESAS';

    public function indexAfter()
    {
        $empresas = Empresa::query()->byPiCliente(Auth::user()->pi_cliente_id)->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('mesas.index',Auth::user()->empresa_id);
        }
        return view('mesas.indexAfter', compact('empresas'));
    }

    public function index()
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresas = Empresa::query()
                        ->byPiCliente(Auth::user()->pi_cliente_id)
                        ->pluck('nombre_comercial','id');
        $sucursales = Sucursal::query()
                        ->byPiCliente(Auth::user()->pi_cliente_id)
                        ->pluck('nombre','id');
        $estados = Zona::ESTADOS;
        $mesas = Mesa::query()
                        ->byPiCliente(Auth::user()->pi_cliente_id)
                        ->orderBy('id','desc')
                        ->paginate(10);
        return view('mesas.index', compact('icono','header','empresas','sucursales','estados','mesas'));
    }

    public function indexAjax(Request $request){
        $mesas = Mesa::query()
                        ->byEmpresa($request->empresa_id)
                        ->with(['sucursal','zona'])
                        ->get();
        $mesas = $mesas->map(function ($mesa) {
            $mesa->estado_mesa = $mesa->status;
            return $mesa;
        });
        return DataTables::of($mesas)
                            ->addColumn('nombre_sucursal', function ($mesa) {
                                return $mesa->sucursal ? $mesa->sucursal->nombre : '-';
                            })
                            ->addColumn('nombre_zona', function ($mesa) {
                                return $mesa->zona ? $mesa->zona->nombre : '-';
                            })
                            ->toJson();
    }

    public function search(Request $request)
    {
        $icono = self::ICONO;
        $header = self::INDEX;
        $empresas = Empresa::query()
                        ->byPiCliente(Auth::user()->pi_cliente_id)
                        ->pluck('nombre_comercial','id');
        $sucursales = Sucursal::query()
                        ->byPiCliente(Auth::user()->pi_cliente_id)
                        ->pluck('nombre','id');
        $estados = Zona::ESTADOS;
        $empresa = Empresa::find($request->empresa_id);
        $mesas = Mesa::query()
                        ->byPiCliente(Auth::user()->pi_cliente_id)
                        ->byEmpresa($request->empresa_id)
                        ->bySucursal($request->sucursal_id)
                        ->byZona($request->zona_id)
                        ->byNumero($request->numero)
                        ->bySillas($request->sillas)
                        ->byDetalle($request->detalle)
                        ->byEstado($request->estado)
                        ->orderBy('id','desc')
                        ->paginate(10);
        return view('mesas.index', compact('icono','header','empresas','sucursales','estados','mesas'));
    }

    public function create(Request $request)
    {
        $icono = self::ICONO;
        $header = self::REGISTRAR;
        $empresas = Empresa::query()
                                ->byPiCliente(Auth::user()->pi_cliente_id)
                                ->pluck('nombre_comercial','id');

        $zona = null;
        $mesa_ocupada_array = null;
        $mesa_id_array = null;
        $cantidad_sillas_array = null;
        $titulo_array = null;
        if(isset($request->zona_id)){
            $zona = Zona::find($request->zona_id);
            $mesas_ocupadas = Mesa::where('zona_id',$zona->id)->where('estado','1')->get();
            if($mesas_ocupadas != null){
                foreach($mesas_ocupadas as $mesa_ocupada){
                    $mesa_id_array[] = $mesa_ocupada->id;
                    $mesa_ocupada_array[] = $mesa_ocupada->posicion;
                    $cantidad_sillas_array[] = $mesa_ocupada->cantidad_sillas;
                    $titulo_array[] = $mesa_ocupada->nombre;
                }
            }
        }
//dd($zona, $mesa_ocupada_array);
        return view('mesas.create', compact('icono','header','empresas','zona','mesa_id_array','mesa_ocupada_array','cantidad_sillas_array','titulo_array'));
    }

    public function getEliminar(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $mesa = Mesa::find($id);
            if($mesa != null){
                $mesa->update([
                    'estado' => '5'
                ]);
                return response()->json([
                    'message' => 'Mesa eliminada'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMesas(Request $request){
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

    public function getAdd(Request $request){
        try{
            $input = $request->all();
            $datos = ([
                'zona_id' => $input['zona_id'],
                'sucursal_id' => $input['sucursal_id'],
                'empresa_id' => $input['empresa_id'],
                'pi_cliente_id' => Auth::user()->pi_cliente_id,
                'nombre' => $input['titulo'],
                'cantidad_sillas' => $input['cantidad_sillas'],
                'posicion' => $input['ubicacion'],
                'estado' => '1'
            ]);

            $mesa = Mesa::create($datos);
            return response()->json([
                'message' => 'Mesa agregada',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPosicion(Request $request){
        try{
            $input = $request->all();
            $mesa_id = $input['mesa_id'];
            $posicion = $input['posicion'];

            $cont = 0;
            while($cont < count($mesa_id)){
                $mesa = Mesa::find($mesa_id[$cont]);
                $mesa->update([
                    'posicion' => $posicion[$cont]
                ]);

                $cont++;
            }

            return response()->json([
                'message' => 'Posiciones actualizadas',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUpdateFc(Request $request){
        try{
            $input = $request->all();
            $zona = Zona::find($input['zona_id']);
            $zona->update([
                'filas' => $input['filas'],
                'columnas' => $input['columnas']
            ]);

            return response()->json([
                'message' => 'Filas y columnas actualizadas',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDatosByEmpresa(Request $request){
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

    public function getDatosBySucursal(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $zonas = Zona::where('sucursal_id', $id)->where('estado','1')->get();
            if(count($zonas) > 0){
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

    public function store(Request $request)
    {dd($request->all());
        try{
            if(isset($request->old_ubicacion)){
                $cont = 0;
                while($cont < count($request->old_ubicacion)){
                    $mesa = Mesa::find($request->old_mesa_id[$cont]);
                    $mesa->update([
                        'posicion' => $request->old_ubicacion[$cont]
                    ]);
                    $cont++;
                }
            }

            /*if(isset($request->ubicacion)){
                $cont = 0;
                while($cont < count($request->ubicacion)){
                    $datos = [
                        'zona_id' => $request->zona_id,
                        'sucursal_id' => $request->sucursal_id,
                        'empresa_id' => $request->empresa_id,
                        'pi_cliente_id' => Auth::user()->pi_cliente_id,
                        'nombre' => $request->nombre[$cont],
                        'cantidad_sillas' => $request->cantidad_sillas[$cont],
                        'posicion' => $request->ubicacion[$cont],
                        'estado' => '1'
                    ];

                    $mesa = Mesa::create($datos);
                    $cont++;
                }
            }*/

            $zona = Zona::find($request->zona_id);
            $zona->update([
                'filas' => $request->_filas,
                'columnas' => $request->_columnas
            ]);

            return redirect()->route('mesas.index')->with('success_message', 'Se agregó una [MESA] en la sucursal seleccionada.');
        } catch (ValidationException $e) {
            return redirect()->route('mesas.create', $request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function storeConf(Request $request)
    {
        dd($request->all());
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

            return redirect()->route('mesas.index')->with('success_message', 'Se Modificó una [MESA] en la sucursal seleccionada.');
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
            return redirect()->back()->with('info_message', 'Se Habilito una [MESA] seleccionada...')->withInput();
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
                'estado' => '5'
            ]);

            $zona = Zona::find($mesa->zona_id);
            $zona->update([
                'mesas_disponibles' => $zona->mesas_disponibles - 1
            ]);
            return redirect()->back()->with('info_message', 'Se Deshabilito una [MESA] seleccionada...')->withInput();
        } catch (ValidationException $e) {
            return redirect()->route('mesas.index',$mesa->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function setting($sucursal_id)
    {
        $icono = self::ICONO;
        $header = self::SETTING;
        $sucursal = Sucursal::find($sucursal_id);
        $zonas = Zona::where('sucursal_id',$sucursal_id)->where('estado','1')->get();
        $empresa = Empresa::find($sucursal->empresa_id);
        return view('mesas.setting', compact('icono','header','zonas','empresa'));
    }

    public function getMesasByZona(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $mesas = Mesa::select(DB::raw("concat('MESA N° ',numero,' (',sillas,' SILLAS)') as numero_sillas"),'id')
                            ->where('zona_id', $id)
                            ->where('estado','1')
                            ->get()
                            ->toJson();
            if($mesas){
                return response()->json([
                    'mesas' => $mesas
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeCargarMesa(Request $request)
    {
        try{
            $mesa = Mesa::find($request->mesa_id);
            $mesa->update([
                'fila' => $request->fila,
                'columna' => $request->columna,
                'estado' => 3
            ]);

            return redirect()->route('mesas.setting', ['sucursal_id' => $mesa->sucursal_id])->with('success_message', '[MESA AGREGADA]');
        } catch (ValidationException $e) {
            return redirect()->route('mesas.setting', $mesa->sucursal_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
