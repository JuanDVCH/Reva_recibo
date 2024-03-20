<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- Define el idioma de la página -->

<head>
    <meta charset="utf-8">
    <!-- Especifica la codificación de caracteres -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Establece la escala inicial y el ancho del viewport -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Define un token CSRF para proteger las solicitudes Ajax -->

    <title>Reva</title>
    <!-- Establece el título de la página -->

    <!-- Bootstrap JS y Popper.js -->
    <!-- Se importan los archivos de JavaScript necesarios para Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Other CSS -->
    <!-- Se importan otros archivos CSS -->
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
    <!-- Se importan los archivos CSS y JavaScript de Tailwind CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="shortcut icon" href="./assets/img/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="/img/3.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!-- Estilos personalizados -->
    <style>
        body {
            display: grid;
            grid-template-rows: 1fr auto;
            min-height: 100vh;
            margin: 0;
            color: #000000;
        }

        #app {
            grid-row: 1;
        }

        .navbar {
            background-color: #28C7AF;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 0;
            /* Elimina los márgenes */
        }
    </style>
</head>

<body>
    <div id="app">
        @auth
            <!-- Si el usuario está autenticado -->
            <!-- Bootstrap Navbar -->
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                <!-- Barra de navegación de Bootstrap -->
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/home') }}">Inicio</a>
                    <a class="navbar-brand" href="{{ route('recibo.index') }}">Recibos</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Menú de navegación -->
                        <!-- Lado izquierdo de la barra de navegación -->
                        <ul class="navbar-nav me-auto">
                            <!-- Puedes agregar más elementos según sea necesario -->
                        </ul>

                        <!-- Lado derecho de la barra de navegación -->
                        <ul class="navbar-nav ms-auto">

                            <!-- Enlaces de autenticación -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                                    style="color: #ffffff; font-weight: bold;">
                                    {{ Auth::user()->name }}
                                    <!-- Muestra el nombre del usuario autenticado -->
                                </a>

                                <div class="dropdown-menu dropdown-menu-end animated fadeIn"
                                    aria-labelledby="navbarDropdown">
                                    <!-- Menú desplegable -->
                                    <!-- Enlace a la ruta del perfil -->
                                    @if (auth()->user()->hasRole('Administrador'))
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}"
                                            style="color: #000000; ">
                                            administración
                                        </a>
                                    @endif
                                    <!-- Enlace para cerrar sesión -->
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        style="color: #000000;">
                                        {{ __('Cerrar sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>


        @endauth
        <!-- Fin de la sección de autenticación -->
        <!-- Contenido principal -->
        <main class="py-4">
            <div class="container">
                @yield('content')
                <!-- Contenido de la página -->
            </div>
        </main>

        <!-- Bootstrap and Tailwind Scripts -->
        <!-- Scripts de Bootstrap y Tailwind -->
        <!-- Incluye el archivo de estilos -->
        <link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/form-validation.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <!-- Incluye el archivo JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdn.jsdelivr.net/jsbarcode/3.11.0/JsBarcode.all.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js">
        </script>

        <!--archivos en public\js JavaScript -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/index.js') }}"></script>
        <script src="{{ asset('js/datatable.js') }}"></script>
        <script src="{{ asset('js/export.js') }}"></script>
        <script src="{{ asset('js/filtres.js') }}"></script>
        <script src="{{ asset('js/alerts.js') }}"></script>


    </div>
</body>
<!-- Fin del cuerpo del documento -->

<!-- Tailwind Footer -->
<footer class="footer relative bg-black pt-6 pb-6" style="margin-top: 150px;">
    <!-- Pie de página con estilo Tailwind -->
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4">
                <h4 class="text-4xl font-semibold text-white">Reva_Col</h4>
                <!-- Título del pie de página -->
                <h5 class="text-lg mt-0 mb-2 text-white">
                    Plataforma digital diseñada para respaldar los procesos llevados a cabo por REVA_Colombia.
                    <!-- Descripción de la plataforma -->
                </h5>
            </div>
            <div class="w-full lg:w-6/12 px-4">
                <!-- Contenedor para enlaces -->
                <div class="flex flex-wrap items-top mb-6">
                    <div class="w-full lg:w-4/12 px-4 ml-auto">
                        <!-- Columna para los enlaces -->
                        <span class="block uppercase text-white text-sm font-semibold mb-2"> Accesos directos</span>
                        <!-- Título de la sección -->
                        <ul class="list-unstyled">
                            <!-- Lista de enlaces -->
                            <li>
                                <!-- Enlaces a recursos externos -->
                                <a class="text-white hover:text-gray-300 font-semibold block pb-2 text-sm"
                                    href="https://eu-show.pulpo.co/#/" target="_blank">
                                    Pulpo WMS
                                </a>
                                <a class="text-white hover:text-gray-300 font-semibold block pb-2 text-sm"
                                    href="https://eu-show.pulpo.co/wizard/#" target="_blank">
                                    PULPO WMS Warehouse Wizard
                                </a>
                                <a class="text-white hover:text-gray-300 font-semibold block pb-2 text-sm"
                                    href="https://intercom.help/pulpo-wms/es/" target="_blank">
                                    PULPO WMS Centro de ayuda
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-400" />
        <!-- Línea divisoria -->
        <div class="flex flex-wrap items-center md:justify-between justify-center">
            <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                <!-- Contenedor para el texto de derechos de autor -->
                <div class="text-sm text-white font-semibold py-1">
                    Copyright © Reva
                    <!-- Texto de derechos de autor -->
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Fin del pie de página -->

</html>
