@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <!-- Contenedor del menú de filtros a la izquierda -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Filtros</h4>
                    </div>
                    <div class="card-body">
                        <!-- Campos de filtro -->
                        <div class="form-group">
                            <label for="filterOrderNum">Order Num:</label>
                            <input type="text" id="filterOrderNum" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="filterDeliveryDate">Delivery Date:</label>
                            <input type="text" id="filterDeliveryDate" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="filterSKU">SKU:</label>
                            <input type="text" id="filterSKU" class="form-control">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger btn-block" onclick="clearFilters()">Eliminar Filtros</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor de la tabla a la derecha -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header flex justify-between items-center bg-blue-500 text-white">
                        <h3 class="m-0">Pulpo WMS</h3>
                        <div class="flex">
                            <button type="button" class="btn btn-primary ml-2" data-bs-toggle="modal"
                                data-bs-target="#createPulpoModal">
                                Crear Pulpo
                            </button>
                            <button class="btn btn-info ml-2" onclick="exportarCSV()">Exportar a CSV</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-fixed-header">
                            <table class="table w-full border border-gray-300">
                                <thead class="bg-blue-200 text-blue-800">
                                    <tr>
                                        <th class="border-r border-gray-300">supplier_code</th>
                                        <th class="border-r border-gray-300">order_num</th>
                                        <th class="border-r border-gray-300">notes</th>
                                        <th class="border-r border-gray-300">delivery_date</th>
                                        <th class="border-r border-gray-300">sku</th>
                                        <th class="border-r border-gray-300">requested_quantity</th>
                                        <th class="border-r border-gray-300">criterium</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pulpos as $order)
                                        <tr>
                                            <td class="border-r border-gray-300">{{ $order->supplier_code }}</td>
                                            <td class="border-r border-gray-300">{{ $order->order_num }}</td>
                                            <td class="border-r border-gray-300">{{ $order->notes }}</td>
                                            <td class="border-r border-gray-300">
                                                {{ \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') }}</td>
                                            <td class="border-r border-gray-300">{{ $order->sku }}</td>
                                            <td class="border-r border-gray-300">{{ $order->requested_quantity }}</td>
                                            <td class="border-r border-gray-300">{{ $order->criterium }}</td>

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

                    <div class="card-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination flex justify-end">
                                <!-- ... (otros elementos) ... -->
                                <li class="page-item {{ $pulpos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $pulpos->previousPageUrl() }}"
                                        tabindex="-1">Previous</a>
                                </li>
                                @for ($i = 1; $i <= $pulpos->lastPage(); $i++)
                                    <li class="page-item {{ $pulpos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $pulpos->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li
                                    class="page-item {{ $pulpos->currentPage() == $pulpos->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $pulpos->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createPulpoModal" tabindex="-1" role="dialog" aria-labelledby="createPulpoModalLabel"
        aria-hidden="true">
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

    <!-- Enlace al archivo de estilos de Tailwind -->
    <link rel="stylesheet" href="{{ asset('css/pulpo.css') }}">
    <style>
        /* Agrega tus estilos personalizados aquí si es necesario */
    </style>
    <!-- Bootstrap JS (asegúrate de que se haya cargado antes de tu script Modals.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tu script JavaScript para exportar a CSV y filtros -->
    <script>
        document.getElementById("filterOrderNum").addEventListener("input", function() {
            applyFilters();
        });

        document.getElementById("filterDeliveryDate").addEventListener("input", function() {
            applyFilters();
        });

        document.getElementById("filterSKU").addEventListener("input", function() {
            applyFilters();
        });

        function applyFilters() {
            var filterOrderNum = document.getElementById("filterOrderNum").value.toLowerCase();
            var filterDeliveryDate = document.getElementById("filterDeliveryDate").value.toLowerCase();
            var filterSKU = document.getElementById("filterSKU").value.toLowerCase();

            var tableRows = document.querySelectorAll("table tbody tr");

            tableRows.forEach(function(row) {
                var orderNum = row.cells[1].innerText.toLowerCase();
                var deliveryDate = row.cells[3].innerText.toLowerCase();
                var sku = row.cells[4].innerText.toLowerCase();

                row.style.display = orderNum.includes(filterOrderNum) &&
                    deliveryDate.includes(filterDeliveryDate) &&
                    sku.includes(filterSKU) ? "" : "none";
            });
        }

        function exportarCSV() {
            var filteredRows = [];

            var tableHeader = Array.from(document.querySelectorAll("table thead tr th")).map(function(cell) {
                return cell.innerText;
            });

            filteredRows.push(tableHeader.join(","));

            var tableRows = document.querySelectorAll("table tbody tr");

            tableRows.forEach(function(row) {
                if (row.style.display !== "none") {
                    var rowData = [];
                    row.querySelectorAll("td").forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    filteredRows.push(rowData.join(","));
                }
            });

            var csvContent = "data:text/csv;charset=utf-8," + filteredRows.join("\n");

            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "pulpo_data.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function clearFilters() {
            document.getElementById("filterOrderNum").value = "";
            document.getElementById("filterDeliveryDate").value = "";
            document.getElementById("filterSKU").value = "";

            // Restaurar la visualización de todas las filas
            var tableRows = document.querySelectorAll("table tbody tr");
            tableRows.forEach(function(row) {
                row.style.display = "";
            });
        }
    </script>
@endsection
