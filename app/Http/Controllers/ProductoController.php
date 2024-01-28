<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Empresa;
use App\Models\Categoria;
use App\Models\Unidad;
use Auth;
use PDF;

class ProductoController extends Controller
{
    public function indexAfter()
    {
        $empresas = Empresa::query()
                            ->byCliente()
                            ->pluck('nombre_comercial','id');
        if(count($empresas) == 1 && Auth::user()->id != 1){
            return redirect()->route('productos.index',Auth::user()->empresa_id);
        }
        return view('productos.indexAfter', compact('empresas'));
    }

    public function index($empresa_id)
    {
        $empresa = Empresa::find($empresa_id);
        $categorias_master = Categoria::where('empresa_id',$empresa_id)->where('nivel','0')->pluck('nombre','id');
        $categorias = Categoria::where('empresa_id',$empresa_id)->where('nivel','1')->pluck('nombre','id');
        $tipos = Categoria::TIPOS;
        $estados = Producto::ESTADOS;
        $productos = Producto::query()
                                ->byEmpresa($empresa_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('productos.index', compact('empresa','categorias_master','categorias','tipos','estados','productos'));
    }

    public function search(Request $request)
    {
        $empresa_id = $request->empresa_id;
        $empresa = Empresa::find($empresa_id);
        $categorias_master = Categoria::where('empresa_id',$empresa_id)->where('nivel','0')->pluck('nombre','id');
        $categorias = Categoria::where('empresa_id',$empresa_id)->where('nivel','1')->pluck('nombre','id');
        $tipos = Categoria::TIPOS;
        $estados = Producto::ESTADOS;
        $productos = Producto::query()
                                ->byEmpresa($empresa_id)
                                ->byProducto($request->producto_id)
                                ->byNombre($request->nombre)
                                ->byNombreFactura($request->nombre_factura)
                                ->byCodigo($request->codigo)
                                ->byUnidad($request->unidad_id)
                                ->byCategoriaMaster($request->categoria_master_id)
                                ->byCategoria($request->categoria_id)
                                ->byTipo($request->tipo)
                                ->byEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        return view('productos.index', compact('empresa','categorias_master','categorias','tipos','estados','productos'));
        
    }

    public function create($id)
    {
        $empresa = Empresa::find($id);
        $categorias_master = Categoria::where('empresa_id',$id)->where('tipo','1')->where('nivel',0)->where('estado','1')->pluck('nombre','id');
        $categorias = Categoria::where('empresa_id',$id)->where('tipo','1')->where('nivel',1)->where('estado','1')->pluck('nombre','id');
        $unidades = Unidad::where('empresa_id',$id)->where('estado','1')->pluck('nombre','id');
        $tipos = Unidad::TIPOS;
        return view('productos.create', compact('empresa','categorias_master','categorias','unidades','tipos'));
    }

    public function getCodigoMaster($id){
        $categoria_master = Categoria::find($id);
        if($categoria_master != null){
            $codigo = $categoria_master->codigo . '-';
            return response()->json([
                'codigo' => $codigo
            ]);
        }

        return response()->json(['error'=>'Algo Salio Mal']);
    }

    public function getCodigo($id){
        $categoria = Categoria::find($id);
        if($categoria != null){
            $categoria_master = Categoria::find($categoria->parent_id);
            if($categoria_master != null){
                $numeracion = Producto::where('categoria_id',$id)->get()->count() + 1;
                $numeracion = $numeracion != null ? str_pad($numeracion, 3, '0', STR_PAD_LEFT) : '001';
                $codigo = $categoria_master->codigo . '-' . $categoria->codigo . '-' . $numeracion;
                return response()->json([
                    'codigo' => $codigo,
                    'categoria_master' => $categoria_master->nombre,
                    'categoria_master_id' => $categoria_master->id
                ]);
            }
        }

        return response()->json(['error'=>'Algo Salio Mal']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_master_id' => 'required',
            'categoria_id' => 'required',
            'nombre' => 'required|unique:productos,nombre,null,id,empresa_id,' . $request->empresa_id,
            'nombre_factura' => 'required|unique:productos,nombre_factura,null,id,empresa_id,' . $request->empresa_id,
            'codigo' => 'required',
            'detalle' => 'required',
            'foto_1' => 'nullable|file|mimes:png|max:2048',
            'foto_2' => 'nullable|file|mimes:png|max:2048',
            'foto_3' => 'nullable|file|mimes:png|max:2048',
        ]);
        try{
            $foto_1 = isset($request->foto_1) ? 'prin_' . strtolower($request->nombre) . '_' . strtolower($request->nombre_factura) . '.' . pathinfo(strtolower($request->foto_1->getClientOriginalName()), PATHINFO_EXTENSION) : null;
            $foto_2 = isset($request->foto_2) ? 'alt(1)_' . strtolower($request->nombre) . '_' . strtolower($request->nombre_factura) . '.' . pathinfo(strtolower($request->foto_2->getClientOriginalName()), PATHINFO_EXTENSION) : null;
            $foto_3 = isset($request->foto_3) ? 'alt(2)_' . strtolower($request->nombre) . '_' . strtolower($request->nombre_factura) . '.' . pathinfo(strtolower($request->foto_3->getClientOriginalName()), PATHINFO_EXTENSION) : null;
            
            $empresa = Empresa::find($request->empresa_id);
            $datos = [
                'empresa_id' => $request->empresa_id,
                'cliente_id' => $empresa->cliente_id,
                'categoria_master_id' => $request->categoria_master_id,
                'categoria_id' => $request->categoria_id,
                'unidad_id' => $request->unidad_id,
                'nombre' => $request->nombre,
                'nombre_factura' => $request->nombre_factura,
                'detalle' => $request->detalle,
                'codigo' => $request->codigo,
                'estado' => '1'
            ];
            $producto = Producto::create($datos);

            $fotos = [
                'foto_1' => 'uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'. $foto_1,
                'foto_2' => 'uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'. $foto_2,
                'foto_3' => 'uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'. $foto_3,
            ];
            $producto->update($fotos);

            $foto_1 = isset($request->foto_1) ? $request->foto_1->move(public_path('uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'), $foto_1) : null;
            $foto_2 = isset($request->foto_2) ? $request->foto_2->move(public_path('uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'), $foto_2) : null;
            $foto_3 = isset($request->foto_3) ? $request->foto_3->move(public_path('uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'), $foto_3) : null;

            return redirect()->route('productos.index',['empresa_id' => $request->empresa_id])->with('success_message', 'Se agregó un producto correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('productos.create',$request->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id)
    {
        $producto = Producto::find($id);
        $empresa = Empresa::find($producto->empresa_id);
        $categorias_master = Categoria::where('empresa_id',$producto->empresa_id)->where('tipo','1')->where('nivel',0)->where('estado','1')->get();
        $categorias = Categoria::where('empresa_id',$producto->empresa_id)->where('tipo','1')->where('nivel',1)->where('estado','1')->get();
        $unidades = Unidad::where('empresa_id',$producto->empresa_id)->where('estado','1')->get();
        return view('productos.editar', compact('producto','empresa','categorias_master','categorias','unidades'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'categoria_master_id' => 'required',
            'categoria_id' => 'required',
            'nombre' => 'required|unique:productos,nombre,' . $request->producto_id . ',id,empresa_id,' . $request->empresa_id,
            'nombre_factura' => 'required|unique:productos,nombre_factura,' . $request->producto_id . ',id,empresa_id,' . $request->empresa_id,
            'codigo' => 'required',
            'detalle' => 'required',
            'foto_1' => 'nullable|file|mimes:png|max:2048',
            'foto_2' => 'nullable|file|mimes:png|max:2048',
            'foto_3' => 'nullable|file|mimes:png|max:2048',
        ]);
        try{
            $foto_1 = isset($request->foto_1) ? 'prin_' . strtolower($request->nombre) . '_' . strtolower($request->nombre_factura) . '.' . pathinfo(strtolower($request->foto_1->getClientOriginalName()), PATHINFO_EXTENSION) : null;
            $foto_2 = isset($request->foto_2) ? 'alt(1)_' . strtolower($request->nombre) . '_' . strtolower($request->nombre_factura) . '.' . pathinfo(strtolower($request->foto_2->getClientOriginalName()), PATHINFO_EXTENSION) : null;
            $foto_3 = isset($request->foto_3) ? 'alt(2)_' . strtolower($request->nombre) . '_' . strtolower($request->nombre_factura) . '.' . pathinfo(strtolower($request->foto_3->getClientOriginalName()), PATHINFO_EXTENSION) : null;

            $empresa = Empresa::find($request->empresa_id);
            $producto = Producto::find($request->producto_id);
            $datos = [
                'empresa_id' => $request->empresa_id,
                'cliente_id' => $empresa->cliente_id,
                'categoria_master_id' => $request->categoria_master_id,
                'categoria_id' => $request->categoria_id,
                'unidad_id' => $request->unidad_id,
                'nombre' => $request->nombre,
                'nombre_factura' => $request->nombre_factura,
                'detalle' => $request->detalle,
                'codigo' => $request->codigo
            ];
            if (!empty($foto_1)) {
                $datos['foto_1'] = 'uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/' . $foto_1;
            }
            if (!empty($foto_2)) {
                $datos['foto_2'] = 'uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/' . $foto_2;
            }
            if (!empty($foto_3)) {
                $datos['foto_3'] = 'uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/' . $foto_3;
            }
            $producto->update($datos);

            $foto_1 = isset($request->foto_1) ? $request->foto_1->move(public_path('uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'), $foto_1) : null;
            $foto_2 = isset($request->foto_2) ? $request->foto_2->move(public_path('uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'), $foto_2) : null;
            $foto_3 = isset($request->foto_3) ? $request->foto_3->move(public_path('uploads/empresas/' . $empresa->id . '/img/productos/' . $producto->id . '/'), $foto_3) : null;

            return redirect()->route('productos.index',['empresa_id' => $request->empresa_id])->with('success_message', 'Se Modifico un producto correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('productos.editar',$request->producto_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function show($id)
    {
        $producto = Producto::find($id);
        $empresa = Empresa::find($producto->empresa_id);
        return view('productos.show', compact('empresa','producto'));
    }

    public function pdf($id)
    {
        $producto = Producto::find($id);
        $pdf = PDF::loadView('productos.pdf',compact(['producto']));
        $pdf->setPaper('LETTER', 'portrait');
        return $pdf->stream();
    }

    public function habilitar($id){
        try{
            $producto = Producto::find($id);
            $producto->update([
                'estado' => '1'
            ]);
            return redirect()->route('productos.index',$producto->empresa_id)->with('info_message', 'Se Habilito el Producto seleccionado...');
        } catch (ValidationException $e) {
            return redirect()->route('productos.index',$producto->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function deshabilitar($id){
        try{
            $producto = Producto::find($id);
            $producto->update([
                'estado' => '2'
            ]);
            return redirect()->route('productos.index',$producto->empresa_id)->with('info_message', 'Se Deshabilito el Producto seleccionado...');
        } catch (ValidationException $e) {
            return redirect()->route('productos.index',$producto->empresa_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
