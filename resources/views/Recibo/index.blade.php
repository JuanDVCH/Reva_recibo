@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="flex justify-between items-center">
                            <h3>Formatos de recibo</h3>
                            <div class="flex">
                                <button type="button" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal"
                                    data-bs-target="#createReceiptModal">
                                    Crear nuevo recibo
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="bg-blue-200 text-blue-800">
                                    <tr>
                                        <th class="border-r border-gray-300">Número de formato</th>
                                        <th class="border-r border-gray-300">Fecha</th>
                                        <th class="border-r border-gray-300">Origen</th>
                                        <th class="border-r border-gray-300">Cliente</th>
                                        <th class="border-r border-gray-300">Código del Cliente</th>
                                        <th class="border-r border-gray-300">Conductor</th>
                                        <th class="border-r border-gray-300">Placa</th>
                                        <th class="border-r border-gray-300">Número de Vehículo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recibos as $recibo)
                                        <tr data-recibo="{{ $recibo->order_num }}">
                                            <td class="border-r border-gray-300">{{ $recibo->order_num }}</td>
                                            <td class="border-r border-gray-300">{{ $recibo->delivery_date }}</td>
                                            <td class="border-r border-gray-300">{{ $recibo->origin }}</td>
                                            <td class="border-r border-gray-300">{{ $recibo->customer }}</td>
                                            <td class="border-r border-gray-300">{{ $recibo->code_customer }}</td>
                                            <td class="border-r border-gray-300">{{ $recibo->driver }}</td>
                                            <td class="border-r border-gray-300">{{ $recibo->plate }}</td>
                                            <td class="border-r border-gray-300">{{ $recibo->num_vehicle }}</td>
                                            <td>
                                                <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                                    class="btn btn-info btn-sm rounded">Detalles</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">No hay datos disponibles</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade rounded" id="createReceiptModal" tabindex="-1" role="dialog" aria-labelledby="createReceiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReceiptModalLabel">Crear un nuevo recibo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('recibo.form') <!-- Asegúrate de tener un formulario aquí -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
