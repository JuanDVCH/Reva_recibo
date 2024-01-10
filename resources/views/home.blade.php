@extends('layouts.app')

@section('content')
<div class="container py-3">
    <!-- Tarjeta Horizontal con Carrusel -->
    <div class="card">
        <div class="row">
            <!-- Contenido de la tarjeta -->
            <div class="col-md-7">
                <div class="card-block">
                    <H1 class="card-text">
                        Formato de recibo.
                    </h1>
                    <h3 class="card-text">
                        Crear formatos de recibo para registrar información detallada de la recepción de materia prima.                 </h3>
                    <br>
                    <a href="{{ route('recibo.index') }}" class="btn home">Crear</a>
                </div>
            </div>

            <!-- Carrusel -->
            <div class="col-md-5">
                <div id="CarouselTest" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="img/reva.jpg" alt="">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/reva.jpg" alt="">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/reva.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="img/reva2.jpg" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h1 class="card-text">Formato de etiqueta.</h1>
                                <p class="card-text">Crear formatos de etiquetas para clasificar las estibas correspondientes.</p>
                                <a href="{{ route('etiqueta.index') }}" class="btn home">Crear</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="img/reva2.jpg" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h1 class="card-text">Pulpo WMS.</h1>
                                <p>Crear y exportar recibos para el sistema de información Pulpo WMS.</p>
                                <a href="{{ route('pulpo.index') }}" class="btn home">Crear</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
