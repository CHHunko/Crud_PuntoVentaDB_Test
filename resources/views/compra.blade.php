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
                <form method="GET" action="{{ route('compra.buscar')}}">
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
                <form method="POST" action="{{ route('compra.anadir')}}">
                    @csrf
                    <label class="form-label">Tipo Documento</label><select class="form-select" name="tipodocumento">
                        <option value="boleta" selected="">Boleta</option>
                        <option value="factura">Factura</option>
                    </select><label class="form-label">Proveedor</label><select class="form-select" name="razonsocial">
                        @foreach ($prov as $list)
                        <option value="{{$list->idproveedor}}">{{$list->razonsocial}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="idpersona" value={{Auth::user()->idpersona;}}>
                    <button class="btn btn-primary" type="submit" style="padding-top: 8px;margin-top: 20px;margin-bottom: 20px;">Crear</button>
                    <hr>
                </form>
            </div>
            <div class="col-md-6 col-xl-8">
                    <div class="table-responsive">
                    <table  class="table" style="background: var(--bs-light);">
        <thead style="background: var(--bs-gray-900);color: var(--bs-body-bg);">
            <tr>
                <th style="width:10%">Fecha Compra</th>
                <th style="width:11%">Documento Proveedor</th>
                <th style="width:10%">Razón Social Proveedor</th>
                <th style="width:10%">Tipo Documento</th>
                <th style="width:10%">Numero Documento</th>
                <th style="width:10%">Encargado Compra</th>
                <th style="width:14%">Total</th>
                <th style="width:12%">Ver</th>
                <th style="width:12%">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $user)
            <tr>
                <td style="width:10%">{{$user->fecharegistro}}</td>
                <td style="width:13%">{{$user->documentop}}</td>
                <td style="width:10%">{{$user->razonsocialp}}</td>
                <td style="width:10%">{{$user->tipodocumento}}</td>
                <td style="width:10%">{{$user->numerodocumento}}</td>
                <td style="width:10%">{{$user->nombrepr}}</td>
                <td style="width:14%">{{$user->montototal}}</td>
                <td style="width:10%">
                <form method="GET" action="{{ route('compra.detalles')}}">
                    <input type="hidden" name="idcompra" value={{$user->idcompra}}>
                    <input type="hidden" name="montototal" value={{$user->montototal}}>
                    <input type="hidden" name="numerodocumento" value={{$user->numerodocumento}}>
                    <button class="btn btn-outline-primary" type="submit">Ver</button>
                </form>
                </td>
                <td style="width:10%">
                <form method="POST" action="{{ route('compra.eliminar')}}">
                    @csrf
                    <input type="hidden" name="idcompra" value={{$user->idcompra}}>
                    <button class="btn btn-outline-primary" type="submit">Eliminar</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
                    </div>
            </div>
        </div>
    </div>


@endsection
