<?php

$si = "Reporte de ".$select."s - C&C Store"
?>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$name}}</title>
</head>
<body>
    <h1 class="display-4 font-monospace text-uppercase text-start" style="margin: 0px;padding-top: 45px;"><?php echo $si  ?></h1>
    <hr>
    <p class="font-monospace fs-3 text-secondary" style="padding-bottom: 37px;">{{$date}}</p>
    <table class="bordered" style="table-layout:fixed; width:100%;">
        <thead style="background-color: rgb(0, 0, 0);
        color: #fff;
        font-size: 14px;">
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
        <tbody style="background-color: rgb(252, 252, 252);
        color: rgb(0, 0, 0);
        font-size: 12px;">
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
</body>
</html>
