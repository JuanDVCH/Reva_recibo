@extends('layouts.app')

@section('content')
    {{-- Agrega los estilos y scripts de DataTables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js">
    </script>

    <style>
        #dataTable_wrapper .dataTable thead th,
        #dataTable_wrapper .dataTable thead td {
            border: none;
            background-color: #f2f2f2;
            /* Color de fondo gris claro */
            border-radius: 0;
            /* Esquinas no redondas */
        }

        #dataTable_filter input {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            background-color: #f2f2f2;
            /* Color de fondo gris claro para el campo de filtro */
        }


        .bg-teal {
            background-color: #4FD1C5;
        }

        .text-teal {
            color: #4FD1C5;
        }

        .btn-teal {
            background-color: #ffffff;
            color: #0f0f0f;
        }

        .btn-teal:hover {
            background-color: #3CB3A6;
        }
    </style>

    <div class="container mx-auto mt-5 mb-5">
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-lg font-semibold text-white">Formatos de recibo</h3>
                <button type="button" class="btn btn-teal btn-sm rounded-md" data-bs-toggle="modal"
                    data-bs-target="#createReceiptModal">
                    Crear nuevo recibo
                </button>
            </div>

            <div class="p-4">
                <div class="table-responsive">
                    <table class="w-full table table-hover shadow-md" id="dataTable">
                        <thead class="bg-teal text-teal">
                            <tr>
                                @foreach (['Número de formato', 'Fecha', 'Origen', 'Cliente', 'Código del Cliente', 'Conductor', 'Placa', 'Número de Vehículo', 'Acciones'] as $header)
                                    <th class="py-3 px-4">{{ $header }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @for ($i = 0; $i < 8; $i++)
                                    <th class="py-3 px-4">
                                        <input type="text" class="form-control filter-input"
                                            data-column="{{ $i }}" placeholder="Filtrar">
                                    </th>
                                @endfor
                                <th class="py-3 px-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recibos as $recibo)
                                <tr data-recibo="{{ $recibo->order_num }}">
                                    @foreach ([$recibo->order_num, $recibo->delivery_date, $recibo->origin, $recibo->customer, $recibo->code_customer, $recibo->driver, $recibo->plate, $recibo->num_vehicle] as $data)
                                        <td class="py-2 px-4">{{ $data }}</td>
                                    @endforeach
                                    <td class="py-2 px-4">
                                        <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                            class="btn btn-info btn-sm rounded-md bg-teal text-white hover:bg-teal-700">
                                            Detalles
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-2 px-4">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createReceiptModal" tabindex="-1" role="dialog" aria-labelledby="createReceiptModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReceiptModalLabel">Crear un nuevo recibo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePdfModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('recibo.form') <!-- Asegúrate de tener un formulario aquí -->
                </div>
            </div>
        </div>
    </div>
    {{-- Inicializa DataTables para tu tabla --}}
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
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
            });

            // Configurar los filtros de DataTables
            table.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('js/Modals.js') }}"></script>

@endsection
