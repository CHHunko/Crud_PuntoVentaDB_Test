<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    function login(){
        return view('auth.login');
    }

    function redirect(){
        return view('dashboard');
    }

    function check(Request $request){
        error_log('esto es 1.');
        $credentials = $request->validate([
            'documento'=>'required',
            'password'=>'required',
        ]);

        error_log('esto es 2.');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            error_log('esto es sucess');
            return redirect()->back()->withSuccess('success');
        }
        else{
            error_log('esto es error');
        return redirect()->back()->withErrors('Documento o contraseña incorrectos');
        }

    }
}
