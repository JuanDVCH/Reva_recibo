@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-4xl font-semibold text-white"><i class="fas fa-list-alt"></i> Formatos de recibo</h3>
                <button type="button" class="btn btn-outline-light btn-lg rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#createReceiptModal">
                    Crear recibo <i class="fas fa-plus text"></i>
                </button>
            </div>
        </div>

        <div class="p-4">
            <div class="mb-4">
                <form id="filtroForm" class="flex items-center">
                    <div class="flex flex-col mr-4">
                        <label for="filtroNumeroFormato" class="block text-sm font-medium text-gray-700">Buscar por Número
                            de Formato:</label>
                        <input type="text" id="filtroNumeroFormato" class="form-input mt-1">
                    </div>
                    <div class="flex flex-col mr-4">
                        <label for="filtroFecha" class="block text-sm font-medium text-gray-700">Buscar por Fecha:</label>
                        <input type="date" id="filtroFecha" class="form-input mt-1">
                    </div>
                    <div class="flex flex-col">
                        <label for="filtroCliente" class="block text-sm font-medium text-gray-700">Buscar por
                            Cliente:</label>
                        <input type="text" id="filtroCliente" class="form-input mt-1">
                    </div>
                </form>
            </div>
            <div class="p-43 mb-10">
                {{ $recibos->appends(request()->input())->links() }}
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" id="listaRecibos">
                @forelse ($recibos as $recibo)
                    <div class="relative bg-gray-100 rounded-md overflow-hidden shadow-md recibo-container">
                        <div class="p-4 overflow-y-auto">
                            <h1 class="text-lg font-semibold">Número de formato</h1>
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
                            <div class="absolute top-0 right-0 m-2">
                                <div class="dropdown">
                                    <button class="btn " type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                            class="dropdown-item">Detalles</a>
                                        <a class="dropdown-item"
                                            href="{{ route('recibo.index', ['id' => $recibo->id]) }}">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="w-full p-4">
                        <p class="text-gray-600">No hay datos disponibles</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="p-43">
            {{ $recibos->appends(request()->input())->links() }}
        </div>
    </div>

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
                    @include('recibo.edit')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createReceiptModal" tabindex="-1" role="dialog" aria-labelledby="createReceiptModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl text-teal-500 font-semibold" id="createReceiptModalLabel">Crear Nuevo formato de
                        recibo</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('recibo.form')
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/Modals.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filtroNumeroFormato = document.getElementById('filtroNumeroFormato');
            const filtroFecha = document.getElementById('filtroFecha');
            const filtroCliente = document.getElementById('filtroCliente');

            const listaRecibos = document.getElementById('listaRecibos');

            [filtroNumeroFormato, filtroFecha, filtroCliente].forEach(input => {
                input.addEventListener('input', () => {
                    const numeroFormato = filtroNumeroFormato.value.trim().toLowerCase();
                    const fecha = filtroFecha.value;
                    const cliente = filtroCliente.value.trim().toLowerCase();

                    Array.from(listaRecibos.children).forEach(recibo => {
                        const numeroFormatoRecibo = recibo.querySelector('.numero-formato')
                            .textContent.trim().toLowerCase();
                        const fechaRecibo = recibo.querySelector('.fecha').textContent;
                        const clienteRecibo = recibo.querySelector('.cliente').textContent
                            .trim().toLowerCase();

                        const mostrarRecibo =
                            (!numeroFormato || numeroFormatoRecibo.includes(
                            numeroFormato)) &&
                            (!fecha || fechaRecibo.includes(fecha)) &&
                            (!cliente || clienteRecibo.includes(cliente));

                        recibo.style.display = mostrarRecibo ? 'block' : 'none';
                    });
                });
            });
        });

        function closePdfModal() {
            $('#createReceiptModal').modal('hide');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const filtroCliente = document.getElementById('filtroCliente');

            filtroCliente.addEventListener('input', () => {
                const cliente = filtroCliente.value.trim();

                fetch(`/recibos?cliente=${cliente}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('listaRecibos').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
