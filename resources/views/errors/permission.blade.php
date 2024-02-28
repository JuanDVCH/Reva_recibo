<!-- resources/views/errors/permission.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center h-screen bg-gray-100">
        <div class="text-center max-w-3xl bg-white p-10 rounded-md shadow-md">
            <!-- Imagen de candado para simbolizar el acceso prohibido -->
            <img src="{{ asset('img/logo_reva-01.png') }}" alt="Candado" class="mx-auto h-32 mb-8">

            <!-- Título llamativo -->
            <h1 class="text-5xl font-extrabold text-green-600">¡Acceso Prohibido!</h1>

            <!-- Mensaje explicativo y amigable -->
            <p class="text-2xl text-gray-700 mt-6">
                Parece que intentaste acceder a una página para la cual no tienes los permisos necesarios.
            </p>

            <!-- Sugerencia de acciones para el usuario -->
            <div class="mt-8">
                <p class="text-xl text-gray-600">
                    Puedes volver a la página de inicio o contactar al administrador si crees que esto es un error.
                </p>
            </div>

            <!-- Enlace y botón para facilitar la navegación -->
            <div class="flex justify-center mt-10 space-x-4">
                <a href="{{ url('/') }}" class="text-blue-500 text-xl hover:underline">Ir a la página de inicio</a>

                <!-- Agregar un botón adicional si se desea -->
                {{-- <button class="bg-blue-500 text-white px-6 py-3 rounded-md text-lg hover:bg-blue-600">Contactar al Administrador</button> --}}
            </div>

            <!-- Mensaje adicional si el usuario está autenticado -->
            @if (Auth::check())
                <p class="text-gray-600 mt-8">Hola, {{ Auth::user()->name }}. ¿Estás seguro de que deberías estar aquí?</p>
            @endif
        </div>
    </div>
@endsection
