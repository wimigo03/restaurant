<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $titulos = Permission::select('title')->groupBy('title')->get();
        $permissions = Permission::orderBy('id','desc')->paginate(10);
        return view('permissions.index', compact('titulos','permissions'));
    }

    public function search(Request $request)
    {
        $titulos = Permission::select('title')->groupBy('title')->get();
        $permissions = Permission::query()
                                    ->byTitulo($request->titulo)
                                    ->orderBy('id','desc')->paginate(10);
        return view('permissions.index', compact('titulos','permissions'));
    }

    public function create()
    {
        $titulos = Permission::select('title')->groupBy('title')->get();
        return view('permissions.create',compact('titulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'nombre' => 'required|unique:permissions,name',
            'descripcion' => 'required',
        ]);
        try{
            $permission = Permission::create([
                'title' => $request->titulo,
                'name' => $request->nombre,
                'description' => $request->descripcion
            ]);
            return redirect()->route('permissions.index')->with('success_message', 'Se agregó un nuevo permiso.');
        } catch (ValidationException $e) {
            return redirect()->route('permissions.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
