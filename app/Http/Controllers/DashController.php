<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DashController extends Controller
{
    function compra(){
        return view('compra');
    }
    function venta(){
        return view('venta');
    }
    function reporteria(){
        return view('reporteria');
    }
}
