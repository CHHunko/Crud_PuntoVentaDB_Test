<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

class ReporteController extends Controller
{

    //acceso a los reportes
    function reporteria(){
        $fecha1= '1900-01-01';
        $fecha2= '3000-01-01';
        $select= 'compra';

        $data=DB::table('compra')
        ->join('proveedor', 'compra.idproveedor', '=', 'proveedor.idproveedor')
        ->join('detallecompra', 'compra.idcompra', '=', 'detallecompra.idcompra')
        ->join('producto', 'detallecompra.idproducto', '=', 'producto.idproducto')
        ->select('compra.*', 'proveedor.documento as documentop', 'proveedor.razonsocial as razonsocialp',
         'producto.nombre as nombrepr', 'detallecompra.cantidad as cantidaddc', 'detallecompra.preciocompra as preciocompradc',
         'detallecompra.precioventa as precioventadc','detallecompra.total as totaldc')
        ->whereBetween('compra.fecharegistro', [$fecha1, $fecha2])
        ->get();

        return view('reporteria',['data' => $data])->with('select', $select)->with('fecha1',$fecha1)->with('fecha2',$fecha2);
    }


    //generacion de tablas por busqueda
    function tabla(Request $request){
        $fecha1= $request->input('fecha1', '1900-01-01');
        $fecha2= $request->input('fecha2', '3000-01-01');
        $select= $request->input('select');

        if($select === 'producto'){
        $data=DB::table('producto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('producto.*', 'categoria.descripcion as descripcionc')
        ->whereBetween('producto.fecharegistro', [$fecha1, $fecha2])
        ->get();
        }
        else if($select === 'venta'){
        $data=DB::table('venta')
        ->join('persona', 'venta.idusuario', '=', 'persona.idpersona')
        ->select('venta.*', 'persona.documento as documentop', 'persona.nombre as nombrep')
        ->whereBetween('venta.fecharegistro', [$fecha1, $fecha2])
        ->get();
        }
        else if($select === 'compra'){
        $data=DB::table('compra')
        ->join('proveedor', 'compra.idproveedor', '=', 'proveedor.idproveedor')
        ->join('detallecompra', 'compra.idcompra', '=', 'detallecompra.idcompra')
        ->join('producto', 'detallecompra.idproducto', '=', 'producto.idproducto')
        ->select('compra.*', 'proveedor.documento as documentop', 'proveedor.razonsocial as razonsocialp',
         'producto.nombre as nombrepr', 'detallecompra.cantidad as cantidaddc', 'detallecompra.preciocompra as preciocompradc',
         'detallecompra.precioventa as precioventadc','detallecompra.total as totaldc')
        ->whereBetween('compra.fecharegistro', [$fecha1, $fecha2])
        ->get();
        }
        return view('reporteria',['data' => $data])->with('select', $select)->with('fecha1',$fecha1)->with('fecha2',$fecha2);
    }


    //deprecada/sin uso, prueba de busqueda de tabla
    function tabla2(Request $request){
        $fecha1 = $request->input();
        $data=DB::table('producto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('producto.*', 'categoria.descripcion')
        ->whereBetween('producto.fecharegistro', ['2022-02-19 08:40:54', '2022-02-20 08:40:54'])
        ->dd();
    }


    //generacion de pdfs
    function pdf(Request $request){
        $fecha1= $request->input('fecha1', '1900-01-01');
        $fecha2= $request->input('fecha2', '3000-01-01');
        $select= $request->input('select');
        $date = date('Y/m/d');
        $name = "Reporte C&C Store - ".$select." - ".$date.".pdf";

        if($select === 'producto'){
        $data=DB::table('producto')
        ->join('categoria', 'producto.idcategoria', '=', 'categoria.idcategoria')
        ->select('producto.*', 'categoria.descripcion as descripcionc')
        ->whereBetween('producto.fecharegistro', [$fecha1, $fecha2])
        ->get();
        }
        else if($select === 'venta'){
        $data=DB::table('venta')
        ->join('persona', 'venta.idusuario', '=', 'persona.idpersona')
        ->select('venta.*', 'persona.documento as documentop', 'persona.nombre as nombrep')
        ->whereBetween('venta.fecharegistro', [$fecha1, $fecha2])
        ->get();
        }
        else if($select === 'compra'){
        $data=DB::table('compra')
        ->join('proveedor', 'compra.idproveedor', '=', 'proveedor.idproveedor')
        ->join('detallecompra', 'compra.idcompra', '=', 'detallecompra.idcompra')
        ->join('producto', 'detallecompra.idproducto', '=', 'producto.idproducto')
        ->select('compra.*', 'proveedor.documento as documentop', 'proveedor.razonsocial as razonsocialp',
         'producto.nombre as nombrepr', 'detallecompra.cantidad as cantidaddc', 'detallecompra.preciocompra as preciocompradc',
         'detallecompra.precioventa as precioventadc','detallecompra.total as totaldc')
        ->whereBetween('compra.fecharegistro', [$fecha1, $fecha2])
        ->get();
        }

        $pdf = PDF::loadView('PDF', compact('data','select','date','name'));

        return $pdf->download($name);
    }

}
