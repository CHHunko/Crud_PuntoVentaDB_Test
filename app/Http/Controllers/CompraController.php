<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class CompraController extends Controller
{
    //acceso a las compras
    function compra(){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';

        $data=DB::table('compra')
        ->join('proveedor', 'compra.idproveedor', '=', 'proveedor.idproveedor')
        ->join('persona', 'compra.idpersona', '=', 'persona.idpersona')
        ->select('compra.*', 'proveedor.documento as documentop', 'proveedor.razonsocial as razonsocialp',
         'persona.nombre as nombrepr')
        ->whereBetween('compra.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $prov=DB::table('proveedor')
        ->select('razonsocial','idproveedor')
        ->get();

        return view('compra',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('prov',$prov);
    }

    //busqueda de compras
    function buscar(Request $request){
        $fecha1= $request->input('fecha1', '1900-01-01');
        $fecha2= $request->input('fecha2', '3000-01-01');

        $data=DB::table('compra')
        ->join('proveedor', 'compra.idproveedor', '=', 'proveedor.idproveedor')
        ->join('persona', 'compra.idpersona', '=', 'persona.idpersona')
        ->select('compra.*', 'proveedor.documento as documentop', 'proveedor.razonsocial as razonsocialp',
         'persona.nombre as nombrepr')
        ->whereBetween('compra.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $prov=DB::table('proveedor')
        ->select('razonsocial','idproveedor')
        ->get();

        return view('compra',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('prov',$prov);
    }

    //Funcion encargada de añadir datos a la principal de compra
    function anadir(Request $request){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';
        $tipodocumento= $request->input('tipodocumento');
        $idproveedor= $request->input('razonsocial');
        $idpersona= $request->input('idpersona');
        $date = date('Y-m-d H:i:s');
        $last = DB::table('compra')->latest('idcompra')->first();
        $ida=$last->idcompra+1;
        $nda=$last->numerodocumento+1;
        $nnda="0000"."$nda";

        //insertamos en la tabla compra
        DB::table('compra')->insert([
            'idcompra' => $ida,
            'idpersona' => $idpersona,
            'idproveedor' => $idproveedor,
            'montototal' => 0,
            'tipodocumento' => $tipodocumento,
            'numerodocumento'=> $nnda,
            'fecharegistro' => $date

        ]);


        $data=DB::table('compra')
        ->join('proveedor', 'compra.idproveedor', '=', 'proveedor.idproveedor')
        ->join('persona', 'compra.idpersona', '=', 'persona.idpersona')
        ->select('compra.*', 'proveedor.documento as documentop', 'proveedor.razonsocial as razonsocialp',
         'persona.nombre as nombrepr')
        ->whereBetween('compra.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $prov=DB::table('proveedor')
        ->select('razonsocial','idproveedor')
        ->get();

        return view('compra',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('prov',$prov);
    }

    //funcion encargada de eliminar el padre de compras y los hijos de detalle compra
    function eliminar(Request $request){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';
        $idcompra= $request->input('idcompra');



        //borramos de la tabla compra y la tabla detalle compra
        $updater=DB::table('detallecompra')
        ->select('detallecompra.*')
        ->where('detallecompra.idcompra', '=', $idcompra)
        ->get();

        foreach ($updater as $list){

            DB::table('producto')
            ->where('idproducto', '=', $list->idproducto)
            ->increment('stock', $list->cantidad);

        }

        DB::table('detallecompra')->where('idcompra', '=', $idcompra)->delete();
        DB::table('compra')->where('idcompra', '=', $idcompra)->delete();


        $data=DB::table('compra')
        ->join('proveedor', 'compra.idproveedor', '=', 'proveedor.idproveedor')
        ->join('persona', 'compra.idpersona', '=', 'persona.idpersona')
        ->select('compra.*', 'proveedor.documento as documentop', 'proveedor.razonsocial as razonsocialp',
         'persona.nombre as nombrepr')
        ->whereBetween('compra.fecharegistro', [$fecha1, $fecha2])
        ->get();

        $prov=DB::table('proveedor')
        ->select('razonsocial','idproveedor')
        ->get();

        return view('compra',['data' => $data])->with('fecha1',$fecha1)->with('fecha2',$fecha2)->with('prov',$prov);
    }


    //detallescompra a partir de aqui, todo es referente a detalles de una compra

    //detalle, para acceder a los detalles
    function detalles(Request $request){
        $idcompra= $request->input('idcompra');
        $montototal= $request->input('montototal');
        $numerodocumento= $request->input('numerodocumento');

        $data=DB::table('detallecompra')
        ->join('producto', 'detallecompra.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detallecompra.*', 'producto.nombre as nombrep',
        'categoria.descripcion as descripcionc')
        ->where('detallecompra.idcompra', '=', $idcompra)
        ->get();


        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

        return view('compradetalles',['data' => $data])->with('prov',$prov)->with('idcompra',$idcompra)->with('montototal',$montototal)
        ->with('numerodocumento',$numerodocumento);
    }


    //insercion de una nueva compra o detalle de compra
    function detallesanadir(Request $request){
        $numerodocumento= $request->input('numerodocumento');
        $idproducto= $request->input('idproducto');
        $cantidad= $request->input('cantidad');
        $idcompra= $request->input('idcompra');
        $montototal= $request->input('montototal');
        $last = DB::table('detallecompra')->latest('iddetallecompra')->first();
        $date = date('Y-m-d H:i:s');

        $ida=$last->iddetallecompra+1;

        $prod= DB::table('producto')
        ->select('idproducto','preciocompra','precioventa','stock')
        ->where('idproducto', '=', $idproducto)->first();

        $cantidadprod=$prod->stock;
        $preciocompra=$prod->preciocompra;
        $precioventa=$prod->precioventa;
        $total=$preciocompra*$cantidad;

        $data=DB::table('detallecompra')
        ->join('producto', 'detallecompra.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detallecompra.*', 'producto.nombre as nombrep',
         'categoria.descripcion as descripcionc')
        ->where('detallecompra.idcompra', '=', $idcompra)
        ->get();


        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->increment('stock', $cantidad);

            DB::table('detallecompra')->insert([
                'iddetallecompra' => $ida,
                'idcompra' => $idcompra,
                'idproducto' => $idproducto,
                'cantidad' => $cantidad,
                'preciocompra' => $preciocompra,
                'precioventa'=> $precioventa,
                'total' => $total,
                'fecharegistro' => $date
            ]);

            DB::table('compra')
            ->where('idcompra', '=', $idcompra)
            ->increment('montototal', $total);

        return redirect()->back();
    }

    function detalleseliminar(Request $request){
        $numerodocumento= $request->input('numerodocumento');
        $idproducto= $request->input('idproducto');
        $cantidad= $request->input('cantidad');
        $idcompra= $request->input('idcompra');
        $montototal= $request->input('montototal');
        $iddetallecompra= $request->input('iddetallecompra');

        $prod= DB::table('producto')
        ->select('idproducto','preciocompra','precioventa','stock')
        ->where('idproducto', '=', $idproducto)->first();


        $cantidadprod=$prod->stock;
        $preciocompra=$prod->preciocompra;
        $precioventa=$prod->precioventa;
        $total=$preciocompra*$cantidad;

        $data=DB::table('detallecompra')
        ->join('producto', 'detallecompra.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detallecompra.*', 'producto.nombre as nombrep',
         'categoria.descripcion as descripcionc')
        ->where('detallecompra.idcompra', '=', $idcompra)
        ->get();


        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

        $deleted2 = DB::table('detallecompra')->where('iddetallecompra', '=', $iddetallecompra)->delete();

            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->decrement('stock', $cantidad);

            DB::table('compra')
            ->where('idcompra', '=', $idcompra)
            ->decrement('montototal', $total);

        return redirect()->back();
    }

    function detalleseditar(Request $request){
        $idproducto= $request->input('idproducto');
        $cantidad= $request->input('cantidad');
        $cantidad2= $request->input('cantidad2');
        $idcompra= $request->input('idcompra');
        $montototal= $request->input('montototal');
        $numerodocumento= $request->input('numerodocumento');
        $iddetallecompra= $request->input('iddetallecompra');
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

            $total=$preciocompra*$cantidad3;

            DB::table('detallecompra')
            ->where('iddetallecompra', '=', $iddetallecompra)
            ->decrement('cantidad', $cantidad3);

            DB::table('detallecompra')
            ->where('iddetallecompra', '=', $iddetallecompra)
            ->decrement('total', $total);

            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->decrement('stock', $cantidad3);

            DB::table('compra')
            ->where('idcompra', '=', $idcompra)
            ->decrement('montototal', $total);

        }
        elseif($cantidad2>$cantidad && $cantidad2!=0){
            $cantidad3=$cantidad2-$cantidad;

            $total=$preciocompra*$cantidad3;

            DB::table('detallecompra')
            ->where('iddetallecompra', '=', $iddetallecompra)
            ->increment('cantidad', $cantidad3);

            DB::table('detallecompra')
            ->where('iddetallecompra', '=', $iddetallecompra)
            ->increment('total', $total);

            DB::table('producto')
            ->where('idproducto', '=', $idproducto)
            ->increment('stock', $cantidad3);

            DB::table('compra')
            ->where('idcompra', '=', $idcompra)
            ->increment('montototal', $total);
        }
        else{}

        }
        else{
        return redirect()->back()->withErrors('No hay Stock');
        }

        $data=DB::table('detallecompra')
        ->join('producto', 'detallecompra.idproducto', '=', 'producto.idproducto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('detallecompra.*', 'producto.nombre as nombrep',
        'categoria.descripcion as descripcionc')
        ->where('detallecompra.idcompra', '=', $idcompra)
        ->get();


        $prov=DB::table('producto')
        ->select('idproducto','nombre','preciocompra','stock')
        ->get();

        return redirect()->back();
    }
}
