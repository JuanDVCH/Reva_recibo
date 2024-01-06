@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Formatos de recibo</h3>
                <div class="d-flex">
                    <button type="button" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal"
                        data-bs-target="#createReceiptModal">
                        Crear nuevo recibo
                    </button>
                </div>
            </div>
            
            <div class="card-body d-flex justify-content-center">
                <div class="table-responsive" style="width: 80%;">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <th scope="col">Numero de formato</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Origen</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Código del Cliente</th>
                            <th scope="col">Conductor</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Número de Vehículo</th>
                            <th scope="col">Acciones</th>
                        </thead>
                        <tbody>
                            @forelse ($recibos as $recibo)
                                <tr data-recibo="{{ $recibo->order_num }}">
                                    <td>{{ $recibo->order_num }}</td>
                                    <td>{{ $recibo->delivery_date }}</td>
                                    <td>{{ $recibo->origin }}</td>
                                    <td>{{ $recibo->customer }}</td>
                                    <td>{{ $recibo->code_customer }}</td>
                                    <td>{{ $recibo->driver }}</td>
                                    <td>{{ $recibo->plate }}</td>
                                    <td>{{ $recibo->num_vehicle }}</td>
                                    <td>
                                        <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                            class="btn btn-info btn-sm">Detalles</a>
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

            <div class="modal fade" id="createReceiptModal" tabindex="-1" role="dialog"
                aria-labelledby="createReceiptModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
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
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
