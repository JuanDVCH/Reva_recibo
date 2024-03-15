@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <!-- Encabezado de la sección -->
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-4xl font-semibold text-white"><i class="fas fa-list-alt"></i> Formatos de recibo</h3>
                <!-- Botón para abrir el modal de creación de recibo -->
                <div class="flex">
                    <button type="button" class="btn btn-outline-light btn-lg rounded-pill mr-2" data-bs-toggle="modal"
                        data-bs-target="#createReceiptModal">
                        Crear recibo <i class="fas fa-plus"></i>
                    </button>
                    <a href="{{ route('recibos.finalizados') }}" class="btn btn-outline-light btn-lg rounded-pill">
                        Ver finalizados <i class="fas fa-list"></i>
                    </a>
                </div>
            </div>
        </div>


        <!-- Formulario de filtrado -->
        <div class="p-4">
            <div class="mb-4">
                <form id="filtroForm" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Input para filtrar por número de formato -->
                    <div class="relative">
                        <input type="text" id="filtroNumeroFormato"
                            class="form-input rounded-lg pl-4 pr-10 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Buscar por Número de Formato">
                        <label for="filtroNumeroFormato"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.293 10.707a1 1 0 0 0 1.414-1.414l5-5a1 1 0 1 0-1.414-1.414l-5 5a1 1 0 0 0 0 1.414z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </label>
                    </div>
                    <!-- Input para filtrar por año -->
                    <div class="relative">
                        <input type="number" id="filtroAnio"
                            class="form-input rounded-lg pl-4 pr-10 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Año">
                        <label for="filtroAnio" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.293 10.707a1 1 0 0 0 1.414-1.414l5-5a1 1 0 1 0-1.414-1.414l-5 5a1 1 0 0 0 0 1.414z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </label>
                    </div>
                    <!-- Input para filtrar por cliente -->
                    <div class="relative">
                        <input type="text" id="filtroCliente"
                            class="form-input rounded-lg pl-4 pr-10 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Buscar por Cliente">
                        <label for="filtroCliente" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.293 10.707a1 1 0 0 0 1.414-1.414l5-5a1 1 0 1 0-1.414-1.414l-5 5a1 1 0 0 0 0 1.414z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </label>
                    </div>
                </form>
            </div>

            <!-- Lista de recibos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" id="listaRecibos">
                <!-- Iteración sobre los recibos para mostrarlos -->
                @forelse ($recibos as $recibo)
                    <div class="relative bg-gray-100 rounded-md overflow-hidden shadow-md recibo-container">
                        <div class="p-4 overflow-y-auto">
                            <!-- Detalles de cada recibo -->
                            <h1 class="text-lg font-semibold">Número de recibo</h1>
                            <p class="numero-formato">{{ $recibo->order_num }}</p>
                            <h1 class="text-lg font-semibold">Fecha:</h1>
                            <p class="fecha">{{ $recibo->delivery_date }}</p>
                            <h1 class="text-lg font-semibold">Origen:</h1>
                            <p>{{ $recibo->origin }}</p>
                            <h1 class="text-lg font-semibold">Cliente:</h1>
                            <p class="cliente">{{ $recibo->customer }}</p>
                            <h1 class="text-lg font-semibold">Código del cliente:</h1>
                            <p>{{ $recibo->code_customer }}</p>
                            <h1 class="text-lg font-semibold">Conductor:</h1>
                            <p>{{ $recibo->driver }}</p>
                            <h1 class="text-lg font-semibold">Placa del vehículo</h1>
                            <p>{{ $recibo->plate }}</p>
                            <h1 class="text-lg font-semibold">Impronta</h1>
                            <p>{{ $recibo->num_vehicle }}</p>
                            <!-- Dropdown para opciones adicionales -->
                            <div class="absolute top-0 right-0 m-2">
                                <div class="dropdown">
                                    <button class="btn " type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <!-- Opciones del dropdown -->
                                        <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                            class="dropdown-item">Detalles
                                        </a>
                                        <a href="{{ route('etiqueta.index') }}" class="dropdown-item">Etiquetas
                                        </a>
                                        <form class="dropdown-item"
                                            action="{{ route('recibo.marcarFinalizado', ['order_num' => $recibo->order_num]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit">finalizado</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Mensaje mostrado si no hay recibos -->
                    <div class="w-full p-4">
                        <p class="text-gray-600">No hay datos disponibles</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal para editar recibo -->
    <div class="modal fade" id="editReceiptModal" tabindex="-1" role="dialog" aria-labelledby="editReceiptModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl text-teal-500 font-semibold" id="editReceiptModalLabel">Editar formato de recibo
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('Receipts.recibo.edit')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear recibo -->
    <div class="modal fade" id="createReceiptModal" tabindex="-1" role="dialog"
        aria-labelledby="createReceiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl text-teal-500 font-semibold" id="createReceiptModalLabel">Crear Nuevo formato de
                        recibo</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('Receipts.recibo.form')
                </div>
            </div>
        </div>
    </div>

    <!-- Enlaces y scripts -->
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/Modals.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
    <!-- JavaScript para filtrado dinámico y carga de datos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lógica para el filtrado dinámico
            const filtroCliente = document.getElementById('filtroCliente');
            const filtroNumeroFormato = document.getElementById('filtroNumeroFormato');
            const filtroAnio = document.getElementById('filtroAnio');

            const listaRecibos = document.getElementById('listaRecibos');

            [filtroCliente, filtroNumeroFormato, filtroAnio].forEach(input => {
                input.addEventListener('input', () => {
                    const cliente = filtroCliente.value.trim().toLowerCase();
                    const numeroFormato = filtroNumeroFormato.value.trim().toLowerCase();
                    const anio = filtroAnio.value.trim().toLowerCase();

                    Array.from(listaRecibos.children).forEach(recibo => {
                        const clienteRecibo = recibo.querySelector('.cliente').textContent
                            .trim().toLowerCase();
                        const numeroFormatoRecibo = recibo.querySelector('.numero-formato')
                            .textContent.trim().toLowerCase();
                        const fechaRecibo = recibo.querySelector('.fecha').textContent
                            .trim();

                        const mostrarRecibo =
                            (!cliente || clienteRecibo.includes(cliente)) &&
                            (!numeroFormato || numeroFormatoRecibo.includes(
                                numeroFormato)) &&
                            (!anio || fechaRecibo.includes(anio));

                        recibo.style.display = mostrarRecibo ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
@endsection
