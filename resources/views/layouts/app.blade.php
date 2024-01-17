<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reva</title>

    <!-- Bootstrap CSS -->

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Other CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/modals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/imprimir.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">


    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        body {
            display: grid;
            grid-template-rows: 1fr auto;
            min-height: 100vh;
            margin: 0;
        }

        #app {
            grid-row: 1;
        }


    </style>
</head>

<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #28C7AF; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">Inicio</a>
                <a class="navbar-brand" href="{{ route('recibo.index') }}">Recibos</a>
                <a class="navbar-brand" href="{{ route('etiqueta.index') }}">Etiquetas</a>
                <a class="navbar-brand" href="{{ route('pulpo.index') }}">Pulpo</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>
        
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                                style="color: #ffffff; font-weight: bold;">
                                {{ Auth::user()->name }}
                            </a>
        
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                                style="background-color: #28C7AF;">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    style="color: #ffffff;">
                                    {{ __('Cerrar sesión') }}
                                </a>
        
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        @endauth
        <!-- Contenido principal -->
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <!-- Tailwind Footer -->
        <footer class="footer">
            <div class="container p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Footer text</h5>
                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                        </p>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Footer text</h5>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center p-3">
                © 2024 Copyright: Reva_Col
            </div>
        </footer>

        <!-- Bootstrap and Tailwind Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/form-validation.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/Modals.js') }}"></script>
        <script src="{{ asset('js/filters.js') }}"></script>
        <script src="{{ asset('js/pagination.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/jsbarcode/3.11.0/JsBarcode.all.min.js"></script>

    </div>
</body>

</html>
