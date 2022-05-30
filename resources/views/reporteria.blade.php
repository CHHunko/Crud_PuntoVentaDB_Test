@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/background.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/tabla.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome.min.css') }}" >
</head>
<div class="container" style="padding-top: 42px;">
    <div class="row">
        <div class="col-xl-12" style="height: 96px;">
            <form method="GET" action="{{ route('reporteria.busqueda')}}">
                <div class="input-group"><input class="form-control" type="date" name="fecha1"><input class="form-control" type="date" name="fecha2"><select class="form-select" name="select">
                            <option value="compra" selected="">Compra</option>
                            <option value="venta">Venta</option>
                            <option value="producto">Productos</option>
                    </select><button class="btn btn-primary" type="submit">Consultar</button></div>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col" style="height: 251px;">
            <div class="table-responsive">
                <table class="table" style="background: var(--bs-light);">
                    <thead style="background: var(--bs-gray-900);color: var(--bs-body-bg);">
                        @if ($select === 'compra')
                        <tr>
                            <th>Fecha Compra</th>
                            <th>Documento Proveedor</th>
                            <th>Razon Social Proveedor</th>
                            <th>Tipo Documento</th>
                            <th>Numero Documento</th>
                            <th>Monto Total</th>
                            <th>Nombre Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Total</th>
                        </tr>
                        @elseif ($select === 'venta')
                        <tr>
                            <th>Fecha Venta</th>
                            <th>Tipo Documento</th>
                            <th>Numero Documento</th>
                            <th>Documento Vendedor</th>
                            <th>Nombre Vendedor</th>
                            <th>Documento Cliente</th>
                            <th>Nombre Cliente</th>
                            <th>Total Pagar</th>
                            <th>Pago con</th>
                            <th>Cambio</th>
                        </tr>
                        @elseif ($select === 'producto')
                        <tr>
                            <th>Fecha Registro</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Categoria</th>
                            <th>Stock</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                        @if ($select === 'compra')
                        @foreach ($data as $user)
                        <tr>
                            <td>{{$user->fecharegistro}}</td>
                            <td>{{$user->documentop}}</td>
                            <td>{{$user->razonsocialp}}</td>
                            <td>{{$user->tipodocumento}}</td>
                            <td>{{$user->numerodocumento}}</td>
                            <td>{{$user->montototal}}</td>
                            <td>{{$user->nombrepr}}</td>
                            <td>{{$user->cantidaddc}}</td>
                            <td>{{$user->preciocompradc}}</td>
                            <td>{{$user->precioventadc}}</td>
                            <td>{{$user->totaldc}}</td>
                        </tr>
                        @endforeach
                        @elseif ($select === 'venta')
                        @foreach ($data as $user)
                        <tr>
                            <td>{{$user->fecharegistro}}</td>
                            <td>{{$user->tipodocumento}}</td>
                            <td>{{$user->numerodocumento}}</td>
                            <td>{{$user->documentop}}</td>
                            <td>{{$user->nombrep}}</td>
                            <td>{{$user->documentocliente}}</td>
                            <td>{{$user->nombrecliente}}</td>
                            <td>{{$user->totalpagar}}</td>
                            <td>{{$user->pagocon}}</td>
                            <td>{{$user->cambio}}</td>
                        </tr>
                        @endforeach
                        @elseif ($select === 'producto')
                        @foreach ($data as $user)
                        <tr>
                            <td>{{$user->fecharegistro}}</td>
                            <td>{{$user->codigo}}</td>
                            <td>{{$user->nombre}}</td>
                            <td>{{$user->descripcion}}</td>
                            <td>{{$user->descripcionc}}</td>
                            <td>{{$user->stock}}</td>
                            <td>{{$user->preciocompra}}</td>
                            <td>{{$user->precioventa}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding-top: 60px;">
    <div class="row">
        <div class="col">
            <form method="POST" action="{{ route('reporteria.pdf')}}">
                @csrf
                <input type="hidden" name="select" value={{$select}}>
                <input type="hidden" name="fecha1" value={{$fecha1}}>
                <input type="hidden" name="fecha2" value={{$fecha2}}>
            <button class="btn btn-success btn-sm font-monospace text-uppercase fs-1 fw-bold text-center border rounded-pill d-inline d-xl-flex flex-grow-1 flex-shrink-1 flex-fill justify-content-start align-items-center align-self-center justify-content-xl-center align-items-xl-center" type="submit" style="width: 1126px;"><i class="fa fa-file-pdf-o"></i>EXPORTAR</button>
        </div>
    </div>
</div>
@endsection
