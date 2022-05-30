@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/background.css') }}" >
</head>
<div class="container" style="position:absolute; left:0; right:0; top: 50%; transform: translateY(-50%); -ms-transform: translateY(-50%); -moz-transform: translateY(-50%); -webkit-transform: translateY(-50%); -o-transform: translateY(-50%);">
    <div class="row justify-content-center">
        <div class="col align-self-center"><img class="rounded-circle img-fluid border border-primary shadow" src="{{asset('429889d1-16d8-4093-82a2-955125e6ddc8.jpg')}}" width="100%" alt="C&amp;C Store"></div>
        <div class="col-md-10 col-lg-9 col-xl-9 col-xxl-7">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h4 class="text-dark mb-4">Porfavor Ingresa tus Datos</h4>
                                </div>
                                <form class="user" method="POST" action="{{ route('auth.check')}}">
                                    @csrf

                                    <div class="mb-3"><input class="form-control form-control-user" type="text" id="documento" value="{{ old('documento') }}" placeholder="Numero Documento" name="documento" required="" maxlength="10" minlength="10" inputmode="numeric" autofocus="">

                                        @if ($errors->any())
                                        <span class="text-danger">Documento o contraseña incorrectos</span>
                                        @endif
                                <span class="text-danger">@error('documento'){{ 'El documento es incorrecto o no esta registrado' }} @enderror</span>
                                </div>
                                    <div class="mb-3"><input class="form-control form-control-user" type="password" id="password" value="{{ old('clave') }}" placeholder="contraseña" name="password" required="" maxlength="3">

                                        <span class="text-danger">@error('clave'){{ 'La contraseña es incorrecta' }} @enderror</span>
                                    </div>
                                    <div class="row mb-3">
                                        <p id="errorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                    </div><button class="btn btn-primary d-block btn-user w-100" id="submit" type="submit">Ingresar</button>
                                    <hr>
                                </form>
                                <div class="text-center"><small>C&amp;C Store, derechos reservados</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
