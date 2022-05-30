<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//login y redirect a dashboard
Route::get('/',[UserAuthController::class,'login']);

Route::get('/home', function(){
    return view('dashboard');
})->middleware('auth');

Route::post('check',[UserAuthController::class,'check'])->name('auth.check');


//desactivar registro, verificacion y reiniciar clave del servicio de autentificacion
Auth::routes([
    'register' => false,
  'verify' => false,
  'reset' => false,
]);


//grupo de autentificacion
Route::group(['middleware'=> 'auth'], function(){
    Route::get('/', [UserAuthController::class, 'redirect'])->name('dashboard');

    //compras
    Route::get('home/compra', [CompraController::class, 'compra'])->name('compra');
    Route::post('home/compra/anadir', [CompraController::class, 'anadir'])->name('compra.anadir');
    Route::post('home/compra/eliminar', [CompraController::class, 'eliminar'])->name('compra.eliminar');
    Route::get('home/compra/busqueda', [CompraController::class, 'buscar'])->name('compra.buscar');
    Route::get('home/compra/detalles', [CompraController::class, 'detalles'])->name('compra.detalles');
    Route::post('home/compra/detalles/editar', [CompraController::class, 'detalleseditar'])->name('compra.detalles.editar');
    Route::post('home/compra/detalles/anadir', [CompraController::class, 'detallesanadir'])->name('compra.detalles.anadir');
    Route::post('home/compra/detalles/eliminar', [CompraController::class, 'detalleseliminar'])->name('compra.detalles.eliminar');

    //ventas
    Route::get('home/venta', [VentaController::class, 'venta'])->name('venta');
    Route::post('home/venta/anadir', [VentaController::class, 'anadir'])->name('venta.anadir');
    Route::post('home/venta/editar', [VentaController::class, 'editar'])->name('venta.editar');
    Route::post('home/venta/eliminar', [VentaController::class, 'eliminar'])->name('venta.eliminar');
    Route::get('home/venta/buscar', [VentaController::class, 'buscar'])->name('venta.buscar');
    Route::get('home/venta/detalles', [VentaController::class, 'detalles'])->name('venta.detalles');
    Route::post('home/venta/detalles/editar', [VentaController::class, 'detalleseditar'])->name('venta.detalles.editar');
    Route::post('home/venta/detalles/anadir', [VentaController::class, 'detallesanadir'])->name('venta.detalles.anadir');
    Route::post('home/venta/detalles/eliminar', [VentaController::class, 'detalleseliminar'])->name('venta.detalles.eliminar');

    //reportes
    Route::get('home/reportes', [ReporteController::class, 'reporteria'])->name('reporteria');
    Route::get('home/reportes/busqueda', [ReporteController::class, 'tabla'])->name('reporteria.busqueda');
    Route::post('home/reportes/pdf', [ReporteController::Class, 'pdf'])->name('reporteria.pdf');
});
