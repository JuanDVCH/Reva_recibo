@extends('layouts.app')

@section('content')
        <div class="container mx-auto mt-12 flex">
            <!-- Formulario para editar perfil -->
            <div class="max-w-xl bg-white p-8 border rounded-md shadow-md mr-8">
                <h2 class="text-2xl font-semibold mb-6">Editar Perfil</h2>

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

                <form action="{{ route('profile.update') }}" method="post">
                    @csrf
                    @method('put')

                    <!-- Campo Nombre -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold mb-2">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                            class="w-full px-3 py-2 border rounded-md @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <label for="email" class="block text-sm font-bold mb-2">Correo Electrónico</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="w-full px-3 py-2 border rounded-md @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <label for="password" class="block text-sm font-bold mb-2">Nueva Contraseña</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-3 py-2 border rounded-md @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <label for="password_confirmation" class="block text-sm font-bold mb-2">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-5 py-2 border rounded-md">
                    </div>



                    <!-- Botón Guardar Cambios -->
                    <div class="mb-4">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sección para la creación de nuevos usuarios -->
            <div class="flex-grow bg-white p-8 border rounded-md shadow-md">
                <h2 class="text-2xl font-semibold mb-6">Usuarios</h2>
                <a href="{{ route('users.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ver Usuarios</a>
            </div>
        </div>

@endsection
