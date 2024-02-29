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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="listaRecibos">
                @forelse ($recibos as $recibo)
                    <div class="relative bg-gray-100 rounded-md overflow-hidden shadow-md recibo-container">
                        <div class="p-4 overflow-y-auto">
                            <!-- Contenido del recibo -->
                            <h1 class="text-lg font-semibold"> Número de formato</h1>
                            <p>{{ $recibo->order_num }}</p>
                            <h1 class="text-lg font-semibold">Fecha:</h1>
                            <p>{{ $recibo->delivery_date }}</p>
                            <h1 class="text-lg font-semibold">Origen:</h1>
                            <p>{{ $recibo->origin }}</p>
                            <h1 class="text-lg font-semibold">Cliente:</h1>
                            <p>{{ $recibo->customer }}</p>
                            <h1 class="text-lg font-semibold">Código del cliente:</h1>
                            <p>{{ $recibo->code_customer }}</p>
                            <h1 class="text-lg font-semibold">Conductor:</h1>
                            <p>{{ $recibo->driver }}</p>
                            <h1 class="text-lg font-semibold">Placa del vehículo</h1>
                            <p>{{ $recibo->plate }}</p>
                            <h1 class="text-lg font-semibold">Impronta</h1>
                            <p>{{ $recibo->num_vehicle }}</p>
                            <!-- Botón de opciones  -->
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

        <!-- Mostrar la paginación -->
        <div class="p-4">
            {{ $recibos->appends(request()->input())->links() }}
        </div>
    </div>

    <!-- Ventana modal de edición -->
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
                    @include('recibo.edit') <!-- Asegúrate de tener un formulario de edición separado -->
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana modal de creación -->
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
            var recibos = document.querySelectorAll('.recibo-container');

            recibos.forEach(function(recibo) {
                recibo.addEventListener('dblclick', function() {
                    // Abre la ventana modal de edición al hacer doble clic
                    $('#editReceiptModal').modal('show');
                });
            });
        });

        function closePdfModal() {
            $('#createReceiptModal').modal('hide');
        }
    </script>
@endsection
