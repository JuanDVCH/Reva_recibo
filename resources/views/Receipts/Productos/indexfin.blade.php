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



<!-- Incluye el archivo de estilos -->
<link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#productsTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            pageLength: 5,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
                lengthMenu: "Mostrar _MENU_ registros por página",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                },
            },
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.header()))
                        .on('keyup change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                });
            },
            "paging": true,
            "ordering": true,
            "info": true,
            "border": false,
        });

        // Elimina los bordes de las columnas
        $('#productsTable').find('thead th').removeClass('sorting sorting_asc sorting_desc');
    });

    function exportToCSV() {
        // Recopila todos los datos, incluso aquellos en páginas no visibles
        var allRows = $('#productsTable').DataTable().rows().data().toArray();

        var aggregatedData = {};

        allRows.forEach(function(row) {
            var orderNum = row[1]; // Ajusta el índice según tu estructura de columna
            var sku = row[4]; // Ajusta el índice según tu estructura de columna
            var netWeight = parseFloat(row[5]) || 0; // Ajusta el índice según tu estructura de columna

            if (!aggregatedData[orderNum + sku]) {
                aggregatedData[orderNum + sku] = {
                    supplier_code: row[0], // Ajusta el índice según tu estructura de columna
                    order_num: orderNum,
                    notes: row[2], // Ajusta el índice según tu estructura de columna
                    delivery_date: row[3], // Ajusta el índice según tu estructura de columna
                    sku: sku,
                    requested_quantity: netWeight,
                    criterium: row[6] // Ajusta el índice según tu estructura de columna
                };
            } else {
                aggregatedData[orderNum + sku].requested_quantity += netWeight;
            }
        });

        var aggregatedArray = Object.values(aggregatedData);

        var csv = Papa.unparse(aggregatedArray, {
            columns: ["supplier_code", "order_num", "notes", "delivery_date", "sku", "requested_quantity",
                "criterium"
            ]
        });

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
