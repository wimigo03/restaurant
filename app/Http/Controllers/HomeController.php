<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $cargo = Auth::user()->cargo;
        $empresas_info = Empresa::where('cliente_id',Auth::user()->cliente_id)->get();
        return view('home.index',compact('empresas_info','cargo'));
    }

    /*public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }*/
}
