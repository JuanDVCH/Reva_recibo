@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal-500 rounded-t-md">
                <div>
                    <h3 class="text-4xl font-semibold text-white">
                        <i class="fas fa-list-alt"></i> Productos
                    </h3>
                    <!-- Muestra el número de recibo seleccionado -->
                    <div class="mt-2 text-lg font-semibold text-white">Recibo N°: {{ $orderNumber }}</div>
                </div>
                <div class="flex space-x-4">
                    <button type="button" class="btn btn-outline-light btn-lg rounded-pill mr-2" data-bs-toggle="modal"
                        data-bs-target="#createProductsModal">
                        Crear nuevo producto
                    </button>

                    <button type="button" class="btn btn-outline-light btn-lg rounded-pill mr-2" onclick="exportToCSV()">
                        Exportar a CSV
                    </button>
                    <a href="{{ route('Receipts.recibo.index') }}" class="btn btn-outline-light btn-lg rounded-pill">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <!-- Muestra la tabla de productos -->
            <div class="p-4">
                <div class="table-responsive">
                    <table class="w-full table table-bordered table-striped table-hover" id="productsTable">
                        <thead class="bg-teal text-white">
                            <tr>
                                <th>supplier_code</th>
                                <th>order_num</th>
                                <th>Notes</th>
                                <th>delivery_date</th>
                                <th>sku</th>
                                <th>requested_quantity</th>
                                <th>criterium</th>
                                <th>Descripción</th>
                                <th>Unidad de Medida</th>
                                <th>Cantidad</th>
                                <th>Peso Bruto</th>
                                <th>Peso de Empaque</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td>{{ optional($producto->recibo)->code_customer }}</td>
                                    <td>{{ optional($producto->recibo)->order_num }}</td>
                                    <td>{{ $producto->notes }}</td>
                                    <td>{{ optional($producto->recibo)->delivery_date }}</td>
                                    <td>{{ $producto->sku }}</td>
                                    <td>{{ $producto->net_weight }}</td>
                                    <td>{{ $producto->criterium }}</td>
                                    <td>{{ $producto->description }}</td>
                                    <td>{{ $producto->unit_measurement }}</td>
                                    <td>{{ $producto->amount }}</td>
                                    <td>{{ $producto->gross_weight }}</td>
                                    <td>{{ $producto->packaging_weight }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createProductsModal" tabindex="-1" role="dialog"
        aria-labelledby="createProductsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h1 class="text-2xl font-semibold">Crear nuevo producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('Receipts.productos.form')
                </div>
            </div>
        </div>
    </div>
@endsection
