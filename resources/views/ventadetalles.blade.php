@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/background.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/tabla1.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome.min.css') }}" >
</head>

<div class="container">
    <div class="row">
        <div class="col-md-12" style="padding-top: 21px;padding-bottom: 29px;">
            <form method="GET" action="{{ route('venta.buscar')}}">
                <div class="input-group">
                    <input class="form-control" type="date" name="fecha1">
                    <input class="form-control" type="date" name="fecha2">
                    <button class="btn btn-primary" type="submit">Consultar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <form method="POST" action="{{ route('venta.detalles.anadir')}}">
                @csrf
                <label class="form-label">Cantidad</label>
                <input class="form-control form-control-user" type="text" id="cantidad" placeholder="Ingrese una cantidad" name="cantidad" required="" maxlength="2" minlength="1" inputmode="numeric" autofocus="">
                @if ($errors->any())
                <span class="text-danger">No hay suficiente Stock para realizar la transacción</span>
                <br>
                @endif
                <label class="form-label">Producto</label><select class="form-select" name="idproducto">
                    @foreach ($prov as $list)
                    <option value="{{$list->idproducto}}">{{$list->nombre}} - {{$list->preciocompra}} - {{$list->stock}}u/d</option>
                    @endforeach
                </select>
                <input type="hidden" name="idventa" value={{$idventa}}>
                    <input type="hidden" name="numerodocumento" value={{$numerodocumento}}>
                    <input type="hidden" name="totalpagar" value={{$totalpagar}}>
                <button class="btn btn-primary" type="submit" style="padding-top: 8px;margin-top: 20px;margin-bottom: 20px;">Crear</button>
                <hr>
            </form>
        </div>
            <div class="col-md-6 col-xl-8">
                <form method="GET" action="{{ route('venta')}}">
                <div class="vstack">
                        <button class="btn btn-primary" type="submit" style="margin-top: 0px;">
                            <i class="fa fa-arrow-circle-left" style="margin-right: 11px;">
                            </i>Regresar</button>
                    </div>
                </form>
                    <div class="table-responsive">
                    <table  class="table" style="background: var(--bs-light);">
        <thead style="background: var(--bs-gray-900);color: var(--bs-body-bg);">
            <tr>
                <th style="width:10%">Fecha Venta</th>
                <th style="width:11%">Nombre Producto</th>
                <th style="width:11%">Categoria</th>
                <th style="width:10%">Cantidad</th>
                <th style="width:10%">Precio Venta</th>
                <th style="width:10%">Subtotal</th>
                <th style="width:12%">Editar</th>
                <th style="width:12%">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $user)
            <tr>
                <td style="width:10%">{{$user->fecharegistro}}</td>
                <td style="width:13%">{{$user->nombrep}}</td>
                <td style="width:10%">{{$user->descripcionc}}</td>
                <form method="POST" action="{{ route('venta.detalles.editar')}}">
                    @csrf
                <td style="width:10%"><input type="text" name="cantidad2" value={{$user->cantidad}} style="width:100%"></td>
                <td style="width:10%">{{$user->precioventa}}</td>
                <td style="width:14%">{{$user->subtotal}}</td>
                <td style="width:10%">
                    <input type="hidden" name="cantidad" value={{$user->cantidad}}>
                    <input type="hidden" name="idventa" value={{$idventa}}>
                    <input type="hidden" name="numerodocumento" value={{$numerodocumento}}>
                    <input type="hidden" name="iddetalleventa" value={{$user->iddetalleventa}}>
                    <input type="hidden" name="idproducto" value={{$user->idproducto}}>
                    <input type="hidden" name="totalpagar" value={{$totalpagar}}>
                    <button class="btn btn-outline-primary" type="submit">Editar</button>
                </form>
                </td>
                <td style="width:10%">
                <form method="POST" action="{{ route('venta.detalles.eliminar')}}">
                    @csrf
                    <input type="hidden" name="idventa" value={{$user->idventa}}>
                    <input type="hidden" name="idproducto" value={{$user->idproducto}}>
                    <input type="hidden" name="totalpagar" value={{$totalpagar}}>
                    <input type="hidden" name="numerodocumento" value={{$numerodocumento}}>
                    <input type="hidden" name="cantidad" value={{$user->cantidad}}>
                    <input type="hidden" name="iddetalleventa" value={{$user->iddetalleventa}}>
                    <button class="btn btn-outline-primary" type="submit">Eliminar</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
            </div>

            <div class="table-responsive">
                <table  class="table" style="background: var(--bs-light);">
    <thead style="background: var(--bs-gray-900);color: var(--bs-body-bg);">
        <tr>
            <th style="width:60%">Venta numero: {{$numerodocumento}}</th>
            <th style="width:20%">Total a pagar: {{$totalpagar}}</th>
        </tr>
    </thead>
</table>
        </div>
        </div>
    </div>


@endsection
