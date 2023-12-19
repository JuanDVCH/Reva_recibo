@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Pulpo WMS</h3>
                <div class="d-flex">
                    <button type="button" class="btn btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#createPulpoModal">
                        Crear Pulpo
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary ml-2">Volver Atrás</a>
                </div>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div class="table-responsive" style="width: 80%;">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Código de Proveedor</th>
                                <th>Número de Orden</th>
                                <th>Notas</th>
                                <th>Fecha de Entrega</th>
                                <th>SKU</th>
                                <th>Cantidad Solicitada</th>
                                <th>Criterio</th>
                                <th>Slug del Comerciante</th>
                                <th>Slug del Canal del Comerciante</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pulpos as $order)
                                <tr>
                                    <td>{{ $order->supplier_code }}</td>
                                    <td>{{ $order->order_num }}</td>
                                    <td>{{ $order->notes }}</td>
                                    <td>{{ $order->delivery_date }}</td>
                                    <td>{{ $order->sku }}</td>
                                    <td>{{ $order->requested_quantity }}</td>
                                    <td>{{ $order->criterium }}</td>
                                    <td>{{ $order->merchant_slug }}</td>
                                    <td>{{ $order->merchant_channel_slug }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createPulpoModal" tabindex="-1" role="dialog" aria-labelledby="createPulpoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPulpoModalLabel">Crear Pulpo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pulpo.form') <!-- Asegúrate de tener un formulario aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace al archivo de estilos -->
    <link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
@endsection
