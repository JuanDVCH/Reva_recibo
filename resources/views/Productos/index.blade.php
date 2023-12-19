@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Tabla de productos</h3>
                <div class="d-flex">
                    <button type="button" class="btn btn-primary ml-2" data-bs-toggle="modal"
                        data-bs-target="#createProductsModal">
                        Crear nuevo producto
                    </button>
                    <a href="{{ route('recibo.index') }}" class="btn btn-secondary ml-2">Volver Atrás</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Unidad de Medida</th>
                                <th>Cantidad</th>
                                <th>Peso Bruto</th>
                                <th>Peso de Empaque</th>
                                <th>Peso Neto</th>
                                <th>Número de Recibo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->code_product }}</td>
                                    <td>{{ $producto->description }}</td>
                                    <td>{{ $producto->unit_measurement }}</td>
                                    <td>{{ $producto->amount }}</td>
                                    <td>{{ $producto->gross_weight }}</td>
                                    <td>{{ $producto->packaging_weight }}</td>
                                    <td>{{ $producto->net_weight }}</td>
                                    <td>{{ optional($producto->recibo)->order_num }}</td>
                                    <td>
                                        <!-- Agrega aquí los botones de acciones si es necesario -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createProductsModal" tabindex="-1" role="dialog"
            aria-labelledby="createProductsModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductsModalLabel">Crear Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('productos.form') <!-- Asegúrate de tener un formulario aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluye el archivo de estilos -->
    <link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
    @endsection
