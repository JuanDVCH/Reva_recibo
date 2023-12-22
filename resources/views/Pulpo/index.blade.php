
@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Pulpo WMS</h3>
                <div class="d-flex">
                    <button type="button" class="btn btn-primary ml-2" data-bs-toggle="modal"
                        data-bs-target="#createPulpoModal">
                        Crear Pulpo
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary ml-2">Volver Atrás</a>
                    <button class="btn btn-info ml-2" onclick="exportarCSV()">Exportar a CSV</button>
                </div>
            </div>
            <div class="card-body d-flex justify-content-center">
                                            <!-- Contenedor del menú de filtros a la izquierda -->
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-header">
                                                        <h4 class="mb-0">Filtros</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Campos de filtro -->
                                                        <div class="form-group">
                                                            <label for="filtroOrden">Número de Orden:</label>
                                                            <input type="text" id="filtroOrden" class="form-control">
                                                        </div>
                
                                                        <div class="form-group">
                                                            <label for="filtroCodigoProducto">Código de Producto:</label>
                                                            <input type="text" id="filtroCodigoProducto" class="form-control">
                                                        </div>
                
                                                        <div class="form-group">
                                                            <label for="filtroFecha">Fecha:</label>
                                                            <input type="date" id="filtroFecha" class="form-control">
                                                        </div>
                
                                                        <div class="form-group">
                                                            <button class="btn btn-danger btn-block" onclick="limpiarFiltros()">Eliminar
                                                                Filtros</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
        <div class="modal fade" id="createPulpoModal" tabindex="-1" role="dialog" aria-labelledby="createPulpoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPulpoModalLabel">Crear Pulpo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
    <script src="{{ asset('js/Modals.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script>
        function exportarCSV() {
            var rows = [];

            // Obtén todas las filas de la tabla
            var tableRows = document.querySelectorAll("table tbody tr");

            // Itera sobre las filas y agrega los datos al array 'rows'
            tableRows.forEach(function (row) {
                var rowData = [];
                row.querySelectorAll("td").forEach(function (cell) {
                    rowData.push(cell.innerText);
                });
                rows.push(rowData.join(","));
            });

            // Crea el contenido del archivo CSV
            var csvContent = "data:text/csv;charset=utf-8," + rows.join("\n");

            // Crea un elemento de enlace temporal y simula el clic para descargar el archivo
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "pulpo_data.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
        <script src="{{ asset('js/filters.js') }}"></script>

@endsection
