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
        $empresa = Empresa::find(1);
        return view('home.index',compact('empresa','cargo'));
    }
}
