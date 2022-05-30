@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/background.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Bold-BS4-Cards-with-Hover-Effect-50-1.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Bold-BS4-Cards-with-Hover-Effect-50.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome.min.css') }}" >
</head>
    <div class="container" style="padding-top: 113px;">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="box">
                    <a href="{{ route('compra') }}" class="stretched-link"></a>
                    <div class="box-img" style="height: 460px;"><img class="shadow-lg" src="{{asset('compra-e1551731934405.jpg')}}" alt="Compra" style="height: 460px;"></div>
                    <div class="box-content">
                        <h4 class="title">Compras</h4>
                        <p class="description"></p>
                        <ul class="social-links">
                        </ul><i class="fa fa-credit-card-alt" style="transform: scale(9.11);padding-top: 30px;color: var(--bs-body-bg);"></i>
                    </div>
                </div>
                <h1 class="title">Compras<br></h1>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="box">
                    <a href="{{ route('venta') }}" class="stretched-link"></a>
                    <div class="box-img" style="height: 460px;"><img src="{{asset('orange-and-turquoise-illustration-social-media-strategy-presentation.jpg')}}" alt="Williamson" style="height: 460px;"></div>
                    <div class="box-content">
                        <h4 class="title">Ventas<br></h4>
                        <p class="description"></p>
                        <ul class="social-links">
                        </ul><i class="fa fa-shopping-cart" style="transform: scale(8.75);padding-top: 29px;color: var(--bs-light);"></i>
                    </div>
                </div>
                <h1 class="title">Ventas<br></h1>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="box">
                    <a href="{{ route('reporteria') }}" class="stretched-link"></a>
                    <div class="box-img" style="height: 460px;"><img src="{{asset('Cómo-incrementar-las-oportunidades-de-venta-en-el-sector-industrial.png')}}" alt="Williamson" style="height: 460px;"></div>
                    <div class="box-content">
                        <h4 class="title">Reporteria<br></h4>
                        <p class="description"></p><i class="fa fa-bar-chart" style="transform: scale(9.11);padding-top: 30px;color: var(--bs-body-bg);"></i>
                    </div>
                </div>
                <h1 class="title">Reporteria<br></h1>
            </div>
        </div>
    </div>
    @endsection
