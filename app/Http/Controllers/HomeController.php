<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\User;
use App\Models\PiCliente;
use Illuminate\Support\Facades\Session;
use Auth;

class HomeController extends Controller
{
    const ICONO = 'fa-solid fa-house fa-fw';
    const INDEX = 'BIENVENIDO';

    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $header = self::INDEX;
        $icono = self::ICONO;
        return view('home.index',compact('header','icono'));
    }

    /*public function change($module){
        Session::put('menu',$module);
        return redirect()->route('home.index');
    }*/

    public function updateDashboard(Request $request)
    {
        $menu = $request->input('menu');
        Session::put('menu',$menu);
        $view = '';

        switch ($menu) {
            case 'OPERATIVO':
                $view = view('layouts.partials.menu-operativo')->render();
                break;
            case 'CONTABLE':
                $view = view('layouts.partials.menu-contable')->render();
                break;
            case 'CONTABLEF':
                $view = view('layouts.partials.menu-contable-f')->render();
                break;
            case 'RESTO':
                $view = view('layouts.partials.menu-resto')->render();
                break;
            case 'RRHH':
                $view = view('layouts.partials.menu-rrhh')->render();
                break;
        }

        return response($view, 200)->header('Content-Type', 'text/html');
    }

    /*public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }*/
}
