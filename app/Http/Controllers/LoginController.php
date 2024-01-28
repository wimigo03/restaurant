<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->estado == 1) {
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->with(['danger_message' => 'Usuario no autorizado']);
            }
        }

        return redirect()->route('login')->with(['danger_message' => 'Credenciales inválidas']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
