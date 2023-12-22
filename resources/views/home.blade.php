<!-- resources/views/tu_vista.blade.php -->
@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/menu.js') }}" defer></script>

    <div class="container-fluid">
        <div class="row">

        @section('menu')
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div id="toggleMenu">&#9776;</div>
                <div id="sideMenu" class="hidden">
                    <!-- Contenido del menú lateral -->
                    <a href="{{ route('recibo.index') }}">Formato de recibo</a>
                    <a href="{{ route('etiqueta.index') }}">Formato de etiqueta</a>
                    <a href="{{ route('pulpo.index') }}">Formato de recibo pulpo wms</a>
                </div>
            @show

            <section class="pt-4">
                <div class="container px-lg-5">
                    <!-- Page Features-->
                    <div class="row gx-lg-5">
                        <!-- Contenido de tu sección -->
                        <div class="col-lg-6 col-xxl-4 mb-5">
                            <div class="card bg-light border-1 h-100">
                                <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4">
                                        <i class="bi bi-collection"></i>
                                    </div>
                                    <h2 class="fs-4 fw-bold"> Formato de recibo</h2>
                                    <a href="{{ route('recibo.index') }}" class="btn btn-dark">ir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-4 mb-5">
                            <div class="card bg-light border-1 h-100">
                                <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4">
                                        <i class="bi bi-collection"></i>
                                    </div>
                                    <h2 class="fs-4 fw-bold"> Formato de etiqueta</h2>
                                    <a href="{{ route('etiqueta.index') }}" class="btn btn-dark">ir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-4 mb-5">
                            <div class="card bg-light border-1 h-100">
                                <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4">
                                        <i class="bi bi-collection"></i>
                                    </div>
                                    <h2 class="fs-4 fw-bold"> Formato pulpo</h2>
                                    <a href="{{ route('pulpo.index') }}" class="btn btn-dark">ir</a>
                                </div>
                            </div>
                        </div>
                        <!-- Repite este bloque para otros elementos -->
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection
