<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class VentaController extends Controller
{
    //acceso a las ventas
    function venta(){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';

        $data=DB::table('venta')
        ->join('persona', 'venta.idusuario', '=', 'persona.idpersona')
        ->select('venta.*', 'persona.nombre as nombrepr')
        ->whereBetween('venta.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $pers=DB::table('persona')
        ->select('documento','nombre')
        ->where('idtipopersona', '=', 3)
        ->get();

        return view('venta',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('pers',$pers);
    }

    //busqueda de compras
    function buscar(Request $request){
        $fecha1= $request->input('fecha1', '1900-01-01');
        $fecha2= $request->input('fecha2', '3000-01-01');

        $data=DB::table('venta')
        ->join('persona', 'venta.idusuario', '=', 'persona.idpersona')
        ->select('venta.*', 'persona.nombre as nombrepr')
        ->whereBetween('venta.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $pers=DB::table('persona')
        ->select('documento','nombre')
        ->where('idtipopersona', '=', '3')
        ->get();

        return view('venta',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('pers',$pers);
    }

    //Funcion encargada de añadir datos a la principal de venta
    function anadir(Request $request){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';
        $tipodocumento= $request->input('tipodocumento');
        $documentocliente= $request->input('documentocliente');
        $idpersona= $request->input('idpersona');
        $date = date('Y-m-d H:i:s');
        $last = DB::table('venta')->latest('idventa')->first();
        $ida=$last->idventa+1;
        $nda=$last->numerodocumento+1;
        $nnda="0000"."$nda";

        $nombr= DB::table('persona')
        ->select('nombre')
        ->where('documento', '=', $documentocliente)->first();

        if(isset($nombr->nombre)){
        $nombrecliente= $nombr->nombre;
        }
        else{$nombrecliente= 'no registrado';}
        //insertamos en la tabla venta
        DB::table('venta')->insert([
            'idventa' => $ida,
            'tipodocumento' => $tipodocumento,
            'numerodocumento' => $nnda,
            'idusuario' => $idpersona,
            'documentocliente' => $documentocliente,
            'nombrecliente'=> $nombrecliente,
            'totalpagar'=> 0,
            'pagocon'=> 0,
            'cambio'=> 0,
            'fecharegistro' => $date
        ]);

        $data=DB::table('venta')
        ->join('persona', 'venta.idusuario', '=', 'persona.idpersona')
        ->select('venta.*', 'persona.nombre as nombrepr')
        ->whereBetween('venta.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $pers=DB::table('persona')
        ->select('documento','nombre')
        ->where('idtipopersona', '=', '3')
        ->get();

        return view('venta',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('pers',$pers);
    }

    //funcion encargada de eliminar el padre de ventas y los hijos de detalle venta
    function eliminar(Request $request){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';
        $idventa= $request->input('idventa');


        //borramos de la tabla compra y la tabla detalle compra
        $updater=DB::table('detalleventa')
        ->select('detalleventa.*')
        ->where('detalleventa.idventa', '=', $idventa)
        ->get();

        foreach ($updater as $list){

            DB::table('producto')
            ->where('idproducto', '=', $list->idproducto)
            ->increment('stock', $list->cantidad);

        }

        DB::table('detalleventa')->where('idventa', '=', $idventa)->delete();
        DB::table('venta')->where('idventa', '=', $idventa)->delete();


        $data=DB::table('venta')
        ->join('persona', 'venta.idusuario', '=', 'persona.idpersona')
        ->select('venta.*', 'persona.nombre as nombrepr')
        ->whereBetween('venta.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $pers=DB::table('persona')
        ->select('documento','nombre')
        ->where('idtipopersona', '=', '3')
        ->get();

        return view('venta',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('pers',$pers);
    }


    //funcion encargada de editar el cambio de la venta
    function editar(Request $request){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';
        $idventa= $request->input('idventa');
        $pagocon= $request->input('pagocon');
        $totalpagar= $request->input('totalpagar');

        if($totalpagar !=0){
        if($pagocon < $totalpagar){
        }
        else{
            $cambio= $pagocon-$totalpagar;

            DB::table('venta')
              ->where('idventa', '=', $idventa)
              ->update(['cambio' => $cambio]);


            DB::table('venta')
            ->where('idventa', '=', $idventa)
            ->update(['pagocon' => $pagocon]);
        }
    }

        $data=DB::table('venta')
        ->join('persona', 'venta.idusuario', '=', 'persona.idpersona')
        ->select('venta.*', 'persona.nombre as nombrepr')
        ->whereBetween('venta.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $pers=DB::table('persona')
        ->select('documento','nombre')
        ->where('idtipopersona', '=', '3')
        ->get();

        return view('venta',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('pers',$pers);
    }


    //detallesventa a partir de aqui, todo es referente a detalles de una venta
    //detalle, para acceder a los detalles
    function detalles(Request $request){
        $idventa= $request->input('idventa');
        $totalpagar= $request->input('totalpagar');
        $numerodocumento= $request->input('numerodocumento');

        error_log($idventa);

        error_log($totalpagar);

        error_log($numerodocumento);

        $data=DB::table('detalleventa')
        ->join('producto', 'detalleventa.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detalleventa.*', 'producto.nombre as nombrep',
        'categoria.descripcion as descripcionc')
        ->where('detalleventa.idventa', '=', $idventa)
        ->get();


        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

        return view('ventadetalles',['data' => $data])->with('prov',$prov)->with('idventa',$idventa)->with('totalpagar',$totalpagar)
        ->with('numerodocumento',$numerodocumento);
    }


    //insercion de una nueva compra o detalle de compra
    function detallesanadir(Request $request){
        $numerodocumento= $request->input('numerodocumento');
        $idproducto= $request->input('idproducto');
        $cantidad= $request->input('cantidad');
        $idventa= $request->input('idventa');
        $totalpagar= $request->input('totalpagar');
        $last = DB::table('detalleventa')->latest('iddetalleventa')->first();
        $date = date('Y-m-d H:i:s');

        $ida=$last->iddetalleventa+1;

        $prod= DB::table('producto')
        ->select('idproducto','preciocompra','precioventa','stock')
        ->where('idproducto', '=', $idproducto)->first();

        $cantidadprod=$prod->stock;
        $preciocompra=$prod->preciocompra;
        $precioventa=$prod->precioventa;
        $total=$precioventa*$cantidad;

        $data=DB::table('detalleventa')
        ->join('producto', 'detalleventa.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detalleventa.*', 'producto.nombre as nombrep',
        'categoria.descripcion as descripcionc')
        ->where('detalleventa.idventa', '=', $idventa)
        ->get();



        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

        if($cantidad <= $cantidadprod){
            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->decrement('stock', $cantidad);

            DB::table('detalleventa')->insert([
                'iddetalleventa' => $ida,
                'idventa' => $idventa,
                'idproducto' => $idproducto,
                'cantidad' => $cantidad,
                'precioventa'=> $precioventa,
                'subtotal' => $total,
                'fecharegistro' => $date
            ]);

            DB::table('venta')
            ->where('idventa', '=', $idventa)
            ->increment('totalpagar', $total);
        }
        else{
        return redirect()->back()->withErrors('No hay Stock');
        }

        return redirect()->back();
    }

    function detalleseliminar(Request $request){
        $numerodocumento= $request->input('numerodocumento');
        $idproducto= $request->input('idproducto');
        $cantidad= $request->input('cantidad');
        $idventa= $request->input('idventa');
        $montototal= $request->input('totalpagar');
        $iddetalleventa= $request->input('iddetalleventa');

        $prod= DB::table('producto')
        ->select('idproducto','preciocompra','precioventa','stock')
        ->where('idproducto', '=', $idproducto)->first();


        $cantidadprod=$prod->stock;
        $preciocompra=$prod->preciocompra;
        $precioventa=$prod->precioventa;
        $total=$precioventa*$cantidad;

        $data=DB::table('detalleventa')
        ->join('producto', 'detalleventa.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detalleventa.*', 'producto.nombre as nombrep',
        'categoria.descripcion as descripcionc')
        ->where('detalleventa.idventa', '=', $idventa)
        ->get();


        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

        $deleted2 = DB::table('detalleventa')->where('iddetalleventa', '=', $iddetalleventa)->delete();

            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->increment('stock', $cantidad);

            DB::table('venta')
            ->where('idventa', '=', $idventa)
            ->decrement('totalpagar', $total);

        return redirect()->back();
    }

    function detalleseditar(Request $request){
        $idproducto= $request->input('idproducto');
        $cantidad= $request->input('cantidad');
        $cantidad2= $request->input('cantidad2');
        $idventa= $request->input('idventa');
        $montototal= $request->input('totalpagar');
        $numerodocumento= $request->input('numerodocumento');
        $iddetalleventa= $request->input('iddetalleventa');
        $cantidad3=0;

        $prod= DB::table('producto')
        ->select('idproducto','preciocompra','precioventa','stock')
        ->where('idproducto', '=', $idproducto)->first();

        $cantidadprod=$prod->stock;
        $preciocompra=$prod->preciocompra;
        $precioventa=$prod->precioventa;


        if($cantidad2 <= $cantidadprod){
        if($cantidad2<=$cantidad && $cantidad2!=0){
            $cantidad3=$cantidad-$cantidad2;

            $total=$precioventa*$cantidad3;

            DB::table('detalleventa')
            ->where('iddetalleventa', '=', $iddetalleventa)
            ->decrement('cantidad', $cantidad3);

            DB::table('detalleventa')
            ->where('iddetalleventa', '=', $iddetalleventa)
            ->decrement('subtotal', $total);

            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->increment('stock', $cantidad3);

            DB::table('venta')
            ->where('idventa', '=', $idventa)
            ->decrement('totalpagar', $total);

        }
        elseif($cantidad2>$cantidad && $cantidad2!=0){
            $cantidad3=$cantidad2-$cantidad;

            $total=$precioventa*$cantidad3;

            DB::table('detalleventa')
            ->where('iddetalleventa', '=', $iddetalleventa)
            ->increment('cantidad', $cantidad3);

            DB::table('detalleventa')
            ->where('iddetalleventa', '=', $iddetalleventa)
            ->increment('subtotal', $total);

            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->decrement('stock', $cantidad3);

            DB::table('venta')
            ->where('idventa', '=', $idventa)
            ->increment('totalpagar', $total);
        }
        else{}

        }
        else{
        return redirect()->back()->withErrors('No hay Stock');
        }

        $data=DB::table('detalleventa')
        ->join('producto', 'detalleventa.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detalleventa.*', 'producto.nombre as nombrep',
        'categoria.descripcion as descripcionc')
        ->where('detalleventa.idventa', '=', $idventa)
        ->get();


        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

        return redirect()->back();
    }
}
