@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-12 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12">
        <!-- Sección de Edición de Perfil -->
        <div class="max-w-lg bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl text-teal-500 font-semibold mb-6">Editar Perfil</h2>

            @if (session('error'))
            <div class="bg-red-500 text-white p-3 mb-4 rounded-md">
                {{ session('error') }}
            </div>
            @endif

            @if (session('success'))
            <div class="bg-green-500 text-white p-3 mb-4 rounded-md">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('profile.update') }}" method="post" onsubmit="return validatePassword();">
                @csrf
                @method('put')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-teal-500">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-600 mb-2">Correo Electrónico</label>
                    <input type="email" name="email" id="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-teal-500">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold text-gray-600 mb-2">Nueva Contraseña</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-teal-500">
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-600 mb-2">Confirmar
                            Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-teal-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-teal-500 text-white px-6 py-3 rounded-md hover:bg-teal-600 focus:outline-none focus:border-teal-700 focus:ring focus:ring-teal-200">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Sección de Funciones de Administración -->
        <div class="max-w-full bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl text-teal-500 font-semibold mb-6">Funciones de Administración</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Sección de Usuarios -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl text-teal-500 font-semibold mb-4">Usuarios</h3>
                    <p class="mb-4">Gestiona los usuarios de tu plataforma.</p>
                    <a href="{{ route('users.index') }}"
                        class="block bg-teal-500 text-white px-6 py-3 rounded-md hover:bg-teal-600 text-center">Ver
                        Usuarios</a>
                </div>

                <!-- Sección de Funciones de Administración -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl text-teal-500 font-semibold mb-4">Cerrar Sesión</h3>
                    <p class="mb-4">Cierra la sesión en todos los dispositivos conectados.</p>
                    <button onclick="logoutAllDevices()"
                        class="block w-full bg-red-500 text-white px-6 py-3 rounded-md hover:bg-red-600 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200">Cerrar
                        Sesión</button>
                </div>

                <!-- Función 2 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl text-teal-500 font-semibold mb-4">Función 2</h3>
                    <!-- Contenido de la función 2 -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function validatePassword() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("password_confirmation").value;

        if (password !== confirmPassword) {
            alert("Las contraseñas no coinciden. Por favor, verifica.");
            return false;
        }

        return true;
    }

    function logoutAllDevices() {
        window.location.href = "{{ route('logout.all') }}";
    }
</script>
@endsection
