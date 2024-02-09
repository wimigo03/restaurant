<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\Cargo;
use App\Models\User;
use App\Models\Personal;
use App\Models\PersonalLaboral;
use App\Models\Categoria;
use App\Models\Horario;
use App\Models\HorarioDetalle;
use App\Models\PlanCuenta;
use Auth;

class EmpresaController extends Controller
{
    public function index($id)
    {
        $empresas = Empresa::where('cliente_id',$id)->paginate(10);
        $cliente = Cliente::find($id);
        $estados = Empresa::ESTADOS;
        return view('empresas.index', compact('empresas','cliente','estados'));
    }

    public function search(Request $request)
    {
        dd($request->all());
        //$empresas = Empresa::where('cliente_id',$id)->paginate(10);
        //$cliente = Cliente::find($id);
        //$estados = Empresa::ESTADOS;
        //return view('empresas.index', compact('empresas','cliente','estados'));
    }

    public function create($id)
    {
        $cliente = Cliente::find($id);
        return view('empresas.create', compact('cliente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_comercial' => 'required|unique:empresas,nombre_comercial,null,id,cliente_id,' . $request->cliente_id,
            'direccion' => 'required',
            'logo' => 'nullable|file|mimes:png|max:2048',
            'cover' => 'nullable|file|mimes:png|max:2048',
            'alias' => 'required|size:3'
        ]);
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $logo = isset($request->logo) ? 'logo.'.pathinfo($request->logo->getClientOriginalName(), PATHINFO_EXTENSION) : null;
            $cover = isset($request->cover) ? 'cover.'.pathinfo($request->cover->getClientOriginalName(), PATHINFO_EXTENSION) : null;
            $empresa = Empresa::create([
                'cliente_id' => $request->cliente_id,
                'nombre_comercial' => $request->nombre_comercial,
                'alias' => $request->alias,
                'url_logo' => $logo,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'url_cover' => $cover,
                'estado' => '1'
                ]);

            $empresa_logo = Empresa::find($empresa->id);
            $empresa_logo = ([
                'url_logo' => 'uploads/empresas/' . $empresa->id . '/logos/' . $logo,
                'url_cover' => 'uploads/empresas/' . $empresa->id . '/logos/' . $cover
            ]);

            $cargo = Cargo::create([
                'empresa_id' => $empresa->id,
                'cliente_id' => $request->cliente_id,
                'plan_cuenta_id'=> null,
                'nombre' => 'GERENTE GENERAL',
                'codigo' => '1',
                'nivel' => '0',
                'parent_id' => null,
                'email' => null,
                'descripcion' => $request->nombre_comercial,
                'alias' => 'GRAL',
                'tipo' => '2',
                'estado' => '1'
            ]);
            
            $username = substr($request->nombre_comercial, 0, 5);
            $user = User::create([
                'cargo_id' => $cargo->id,
                'empresa_id' => $empresa->id,
                'cliente_id' => $request->cliente_id,
                'name' => $request->nombre_comercial,
                'username' => $username,
                'password' => bcrypt('123456654321'),
                'estado' => '1'
            ]);

            $personal = Personal::create([
                'user_id' => $user->id,
                'cargo_id' => $cargo->id,
                'empresa_id' => $empresa->id,
                'cliente_id' => $request->cliente_id,
                'estado' => '1'
            ]);

            $gestion = substr(date('Y'), 2, 4);
            $nro_contrato = count(PersonalLaboral::where('empresa_id',$empresa->id)->get()) + 1;
            $nro_contrato = str_pad($nro_contrato, 3, '0', STR_PAD_LEFT);
            $codigo_ingreso = $empresa->alias . '-' . $gestion . '-' . $nro_contrato;

            $personal_laboral = PersonalLaboral::create([
                'personal_id' => $personal->id,
                'user_id' => $user->id,
                'cargo_id' => $cargo->id,
                'empresa_id' => $empresa->id,
                'cliente_id' => $request->cliente_id,
                'horario_id' => NULL,
                'codigo_ingreso' => $codigo_ingreso,
                'biometrico_id' => NULL,
                'tipo_contrato' => NULL,
                'fecha_contrato_fijo' => NULL,
                'profesion_ocupacion' => NULL,
                'banco' => NULL,
                'nro_cuenta' => NULL,
                'estado' => '1'
            ]);

            $cuentas = PlanCuenta::CUENTAS;
            $cont = 1;
            while($cont <= count($cuentas)){
                $plan_de_cuenta = PlanCuenta::create([
                    'empresa_id' => $empresa->id,
                    'cliente_id' => $request->cliente_id,
                    'moneda_id' => 2,
                    'nombre' => $cuentas[$cont],
                    'codigo' => $cont,
                    'nivel' => '0',
                    'parent_id' => null,
                    'auxiliar' => '0',
                    'cheque' => '0',
                    'detalle' => '0',
                    'estado' => '1'
                ]);

                $cont++;
            }

            $logo = isset($request->logo) ? $request->logo->move(public_path('uploads/empresas/' . $empresa->id . '/logos/'), $logo) : null;
            $cover = isset($request->cover) ? $request->cover->move(public_path('uploads/empresas/' . $empresa->id . '/logos/'), $cover) : null;

            return redirect()->route('empresas.index',$request->cliente_id)->with('success_message', 'Se agregó una empresa correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('empresas.create',$request->cliente_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function editar($empresa_id)
    {
        $empresa = Empresa::find($empresa_id);
        $cliente = Cliente::find($empresa->cliente_id);
        return view('empresas.editar', compact('empresa','cliente'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre_comercial' => 'required|unique:empresas,nombre_comercial,' . $request->empresa_id . ',id,cliente_id,' . $request->cliente_id,
            'direccion' => 'required',
            'logo' => 'nullable|file|mimes:png|max:2048',
            'cover' => 'nullable|file|mimes:png|max:2048'
        ]);
        try{
            $logo = isset($request->logo) ? 'logo.'.pathinfo($request->logo->getClientOriginalName(), PATHINFO_EXTENSION) : null;
            $cover = isset($request->cover) ? 'cover.'.pathinfo($request->cover->getClientOriginalName(), PATHINFO_EXTENSION) : null;
            $empresa = Empresa::find($request->empresa_id);
            $empresa->update([
                'cliente_id' => $request->cliente_id,
                'nombre_comercial' => $request->nombre_comercial,
                'url_logo' => $logo,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'url_cover' => $cover,
                'estado' => '1'
                ]);
            $logo = isset($request->logo) ? $request->logo->move(public_path('uploads/empresas/' . $empresa->id . '/img/'), $logo) : null;
            $cover = isset($request->cover) ? $request->cover->move(public_path('uploads/empresas/' . $empresa->id . '/img/'), $cover) : null;
            return redirect()->route('empresas.index',$request->cliente_id)->with('success_message', 'Se modifico una empresa correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('empresas.update',$request->cliente_id)
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
