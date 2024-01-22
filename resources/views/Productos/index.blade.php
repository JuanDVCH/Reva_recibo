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
                    <button type="button" class="btn btn-success ml-2" onclick="exportToCSV()">
                        Exportar a CSV
                    </button>
                    <a href="{{ route('recibo.index') }}" class="btn btn-secondary ml-2">Volver Atrás</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productsTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
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
                                    <td colspan="10">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="createProductsModal" tabindex="-1" role="dialog" aria-labelledby="createProductsModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductsModalLabel">Crear Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="closePdfModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script>
    function exportToCSV() {
        // Crear un objeto para almacenar datos agregados por SKU
        var aggregatedData = {};

        // Iterar a través de las filas de la tabla y agregar datos
        $('#productsTable tbody tr').each(function (index, row) {
            var supplierCode = $(row).find('td:nth-child(1)').text(); // Obtener el proveedor desde la primera columna
            var orderNum = $(row).find('td:nth-child(2)').text();
            var notes = $(row).find('td:nth-child(3)').text();
            var deliveryDate = $(row).find('td:nth-child(4)').text();
            var sku = $(row).find('td:nth-child(5)').text();
            var requestedQuantity = $(row).find('td:nth-child(6)').text();
            var criterium = $(row).find('td:nth-child(7)').text();

            if (!aggregatedData[sku]) {
                // Si SKU no está en aggregatedData, inicializarlo
                aggregatedData[sku] = {
                    supplierCode: supplierCode,
                    orderNum: orderNum,
                    notes: notes,
                    deliveryDate: deliveryDate,
                    sku: sku,
                    requestedQuantity: requestedQuantity,
                    criterium: criterium
                };
            }
        });

        // Convertir los datos agregados a un array
        var aggregatedArray = Object.values(aggregatedData);

        // Convertir los datos al formato CSV utilizando PapaParse
        var csv = Papa.unparse(aggregatedArray, {
            columns: ["supplierCode", "orderNum", "notes", "deliveryDate", "sku", "requestedQuantity", "criterium"]
        });

        // Crear un Blob e iniciar la descarga
        var blob = new Blob([csv], {
            type: 'text/csv;charset=utf-8;'
        });
        var link = document.createElement('a');
        var url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'productos.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    </script>
@endsection
