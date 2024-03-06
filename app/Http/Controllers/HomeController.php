<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $empresas = Empresa::query()->byCliente()->get();
        return view('home.index',compact('empresas'));
    }

    /*public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }*/
}
