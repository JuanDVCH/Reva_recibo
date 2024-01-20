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
            // Create an object to store aggregated data by SKU
            var aggregatedData = {};

            // Iterate through table rows and aggregate data
            $('#productsTable tbody tr').each(function(index, row) {
                var sku = $(row).find('td:first-child').text(); // Assuming SKU is in the first column
                var netWeight = parseFloat($(row).find('td:nth-child(7)')
            .text()); // Assuming Net Weight is in the seventh column
                var receiptNumber = $(row).find('td:last-child')
            .text(); // Assuming Receipt Number is in the last column

                if (!aggregatedData[sku]) {
                    // If SKU is not in the aggregatedData, initialize it
                    aggregatedData[sku] = {
                        sku: sku,
                        netWeight: netWeight,
                        receiptNumber: receiptNumber
                    };
                } else {
                    // If SKU is already in the aggregatedData, update the netWeight
                    aggregatedData[sku].netWeight += netWeight;
                }
            });

            // Convert the aggregated data to an array
            var aggregatedArray = Object.values(aggregatedData);

            // Select only required fields for export
            var exportData = aggregatedArray.map(function(item) {
                return {
                    sku: item.sku,
                    netWeight: item.netWeight,
                    receiptNumber: item.receiptNumber
                };
            });

            // Convert the data to CSV format using PapaParse
            var csv = Papa.unparse(exportData);

            // Create a Blob and initiate a download
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
