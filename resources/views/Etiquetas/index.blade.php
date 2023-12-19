@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Listado de Etiquetas</h3>
                <div class="d-flex">
                    <a href="{{ route('etiqueta.create') }}" class="btn btn-secondary ml-2">Nueva Etiqueta</a>
                    <a href="{{ route('home') }}" class="btn btn-secondary ml-2">Volver Atrás</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Número de Orden</th>
                                <th>Código del Producto</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Origen</th>
                                <th>Amount</th>
                                <th>Peso</th>
                                <th>Tipo</th>
                                <th>Contenido</th>
                                <th>Estado del Producto</th>
                                <th>Color</th>
                                <th>Código de Barras</th>
                                <th>Impresión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($etiquetas as $etiqueta)
                                <tr>
                                    <td>{{ $etiqueta->order_num }}</td>
                                    <td>{{ $etiqueta->code_product }}</td>
                                    <td>{{ $etiqueta->description }}</td>
                                    <td>{{ $etiqueta->delivery_date }}</td>
                                    <td>{{ $etiqueta->origin }}</td>
                                    <td>{{ $etiqueta->amount }}</td>
                                    <td>{{ $etiqueta->weight }}</td>
                                    <td>{{ $etiqueta->type }}</td>
                                    <td>{{ $etiqueta->content }}</td>
                                    <td>{{ $etiqueta->product_status }}</td>
                                    <td>{{ $etiqueta->color }}</td>
                                    <td>
                                        {!! DNS1D::getBarcodeHTML($etiqueta->barcode, 'C128') !!}
                                        {{ $etiqueta->barcode }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="openPdfModal('{{ route('etiquetas.imprimir', ['id_tag' => $etiqueta->id_tag]) }}')" class="btn btn-info">Imprimir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana modal para el PDF -->
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Vista previa del PDF</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Iframe para mostrar el PDF -->
                    <iframe id="pdfIframe" width="100%" height="600px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para abrir la ventana modal con el PDF -->
    <script>
        function openPdfModal(pdfUrl) {
            $('#pdfModal').modal('show');
            $('#pdfIframe').attr('src', pdfUrl);
        }
    </script>
@endsection
