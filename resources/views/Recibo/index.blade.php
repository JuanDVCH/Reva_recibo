@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-4xl font-semibold text-white"><i class="fas fa-list-alt"></i>
                    Formatos de recibo
                </h3>
                <button type="button" class="btn btn-outline-light btn-lg rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#createReceiptModal">
                    Crear recibo <i class="fas fa-plus text"></i>
                </button>

            </div>
        </div>

        <div class="p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="listaRecibos">
                @forelse ($recibos as $recibo)
                    <div class="bg-gray-100 rounded-md overflow-hidden shadow-md">
                        <div class="p-4 overflow-y-auto">
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
                            <!-- Botón de detalles siempre al final -->
                            <div class="mt-4">
                                <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                    class="btn btn-info btn-sm rounded">Detalles</a>
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
    </div>



    <div class="modal fade" id="createReceiptModal" tabindex="-1" role="dialog" aria-labelledby="createReceiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReceiptModalLabel">Crear un nuevo recibo</h5>
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
        function closePdfModal() {
            $('#createReceiptModal').modal('hide');
        }
    </script>
@endsection
