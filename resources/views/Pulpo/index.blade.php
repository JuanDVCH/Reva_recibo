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
            </div>
            <div class="card-body d-flex justify-content-center">

                <div class="table-responsive" style="width: 80%;">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>supplier_code</th>
                                <th>order_num<input type="text" id="filterOrderNum"></th>
                                <th>notes</th>
                                <th>delivery_date</th>
                                <th>sku<input type="text" id="filterSKU"></th>
                                <th>requested_quantity</th>
                                <th>criterium</th>
                                <th>merchant_slug</th>
                                <th>merchant_channel_slug</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $orders = [];
                            @endphp

                            @forelse ($pulpos as $order)
                                @php
                                    $orderKey = $order->order_num . '-' . $order->sku;
                                @endphp

                                @if (isset($orders[$orderKey]))
                                    @php
                                        $orders[$orderKey]['requested_quantity'] += $order->requested_quantity;
                                    @endphp
                                @else
                                    @php
                                        $orders[$orderKey] = [
                                            'supplier_code' => $order->supplier_code,
                                            'order_num' => $order->order_num,
                                            'notes' => $order->notes,
                                            'delivery_date' => $order->delivery_date,
                                            'sku' => $order->sku,
                                            'requested_quantity' => $order->requested_quantity,
                                            'criterium' => $order->criterium,
                                            'merchant_slug' => $order->merchant_slug,
                                            'merchant_channel_slug' => $order->merchant_channel_slug,
                                        ];
                                    @endphp
                                @endif
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay datos disponibles</td>
                                </tr>
                            @endforelse

                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order['supplier_code'] }}</td>
                                    <td>{{ $order['order_num'] }}</td>
                                    <td>{{ $order['notes'] }}</td>
                                    <td>{{ $order['delivery_date'] }}</td>
                                    <td>{{ $order['sku'] }}</td>
                                    <td>{{ $order['requested_quantity'] }}</td>
                                    <td>{{ $order['criterium'] }}</td>
                                    <td>{{ $order['merchant_slug'] }}</td>
                                    <td>{{ $order['merchant_channel_slug'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

    <!-- Enlace al archivo de estilos -->
    <link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
    <!-- Bootstrap JS (asegúrate de que se haya cargado antes de tu script Modals.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
    <script>
        document.getElementById("filterOrderNum").addEventListener("input", function() {
            applyFilters();
        });

        document.getElementById("filterSKU").addEventListener("input", function() {
            applyFilters();
        });

        function applyFilters() {
            
            var filterOrderNum = document.getElementById("filterOrderNum").value.toLowerCase();
            var filterSKU = document.getElementById("filterSKU").value.toLowerCase();

            var tableRows = document.querySelectorAll("table tbody tr");

            tableRows.forEach(function(row) {
                var orderNum = row.cells[1].innerText.toLowerCase();
                var sku = row.cells[4].innerText.toLowerCase();

                row.style.display = orderNum.includes(filterOrderNum) && sku.includes(filterSKU) ? "" : "none";
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
