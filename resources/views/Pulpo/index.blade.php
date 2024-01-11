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
                    <button class="btn btn-info ml-2" onclick="exportarCSV()">Exportar a CSV</button>
                </div>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div class="table-responsive table-fixed-header">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>supplier_code</th>
                                <th>order_num<input type="text" id="filterOrderNum" class="form-control"></th>
                                <th>notes</th>
                                <th>delivery_date<input type="text" id="filterDeliveryDate" class="form-control"></th>
                                <th>sku<input type="text" id="filterSKU" class="form-control"></th>
                                <th>requested_quantity</th>
                                <th>criterium</th>
                                <th>merchant_slug</th>
                                <th>merchant_channel_slug</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pulpos as $order)
                                <tr>
                                    <td>{{ $order->supplier_code }}</td>
                                    <td>{{ $order->order_num }}</td>
                                    <td>{{ $order->notes }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') }}</td>
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
            
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <!-- ... (otros elementos) ... -->
                        <li class="page-item {{ $pulpos->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $pulpos->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>
                        @for ($i = 1; $i <= $pulpos->lastPage(); $i++)
                            <li class="page-item {{ $pulpos->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $pulpos->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $pulpos->currentPage() == $pulpos->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $pulpos->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
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

    <!-- Enlace al archivo de estilos -->
    <link rel="stylesheet" href="{{ asset('css/tablestyles.css') }}">
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

            tableRows.forEach(function (row) {
                if (row.style.display !== "none") {
                    var rowData = [];
                    row.querySelectorAll("td").forEach(function (cell) {
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
    </script>
    <script>
        document.getElementById("filterSupplier").addEventListener("input", function() {
            filterSuppliers();
        });
    
        function filterSuppliers() {
            var filterValue = document.getElementById("filterSupplier").value.toLowerCase();
            var options = document.getElementById("supplierSelect").options;
    
            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].text.toLowerCase();
                options[i].style.display = optionText.includes(filterValue) ? "" : "none";
            }
        }
    </script>
@endsection
