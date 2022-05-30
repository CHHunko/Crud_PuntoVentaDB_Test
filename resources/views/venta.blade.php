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
                <form method="POST" action="{{ route('venta.anadir')}}">
                    @csrf
                    <label class="form-label">Cliente</label><input class="form-control form-control-user" type="text" name="documentocliente" list="clientes" required="" maxlength="10" minlength="10" inputmode="numeric" autofocus="">
                    <datalist id="clientes">
                        @foreach ($pers as $list)
                        <option value="{{$list->documento}}">{{$list->nombre}}</option>
                        @endforeach
                    </datalist><label class="form-label">Tipo Documento</label><select class="form-select" name="tipodocumento">
                        <option value="boleta" selected="">Boleta</option>
                        <option value="factura">Factura</option>
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
                <th >Fecha Venta</th>
                <th >Documento Cliente</th>
                <th >Nombre Cliente</th>
                <th >Tipo Documento</th>
                <th >Numero Documento</th>
                <th >Encargado Venta</th>
                <th >Total Pagar</th>
                <th >Pago con</th>
                <th >Cambio</th>
                <th >Editar</th>
                <th >Ver</th>
                <th >Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $user)
            <tr>
                <td >{{$user->fecharegistro}}</td>
                <td >{{$user->documentocliente}}</td>
                <td >{{$user->nombrecliente}}</td>
                <td >{{$user->tipodocumento}}</td>
                <td >{{$user->numerodocumento}}</td>
                <td >{{$user->nombrepr}}</td>
                <td >{{$user->totalpagar}}</td>
                <form method="POST" action="{{ route('venta.editar')}}">
                    @csrf
                    <td style="width:18%"><input type="text" name="pagocon" value={{$user->pagocon}} style="width:90px"></td>
                <td style="width:10%">{{$user->cambio}}</td>
                <td>
                    <input type="hidden" name="idventa" value={{$user->idventa}}>
                    <input type="hidden" name="totalpagar" value={{$user->totalpagar}}>
                    <button class="btn btn-outline-primary" type="submit">Editar</button>
                </form>
                </td>
                <td style="width:10%">
                <form method="GET" action="{{ route('venta.detalles')}}">
                    <input type="hidden" name="idventa" value={{$user->idventa}}>
                    <input type="hidden" name="totalpagar" value={{$user->totalpagar}}>
                    <input type="hidden" name="numerodocumento" value={{$user->numerodocumento}}>
                    <button class="btn btn-outline-primary" type="submit">Ver</button>
                </form>
                </td>
                <td style="width:10%">
                <form method="POST" action="{{ route('venta.eliminar')}}">
                    @csrf
                    <input type="hidden" name="idventa" value={{$user->idventa}}>
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
