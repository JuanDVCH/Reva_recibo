
@extends('layouts.app')

@section('content')


    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Listado de Etiquetas</h3>
                            <div class="d-flex">
                                <button type="button" class="btn btn-primary ml-2" data-bs-toggle="modal"
                                    data-bs-target="#createTagsModal">
                                    Nueva etiqueta
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-secondary btn-sm ml-2">Volver Atrás</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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

                            <!-- Contenedor de la tabla a la derecha -->
                            <div class="col-md-9">
                                <div id="etiquetaTableBody" class="table-responsive">
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
                                        <tbody id="etiquetaTableBody">
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
                                                        <a href="javascript:void(0)"
                                                            onclick="openPdfModal('{{ route('etiquetas.imprimir', ['id_tag' => $etiqueta->id_tag]) }}')"
                                                            class="btn btn-info btn-sm">Imprimir</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="13">No hay datos disponibles</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- Agregar la paginación si hay más de 5 registros -->

                                    @if ($etiquetas->total() > $etiquetas->perPage())
                                        <div class="d-flex justify-content-end">
                                            {{ $etiquetas->links('pagination::bootstrap-4') }}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePdfModal()">
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
    <div class="modal fade" id="createTagsModal" tabindex="-1" role="dialog" aria-labelledby="createTagsModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="createTagsModalLabel">Crear Etiqueta</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closecreateTagsModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('etiquetas.form') <!-- Asegúrate de tener un formulario aquí -->
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/Modals.js') }}"></script>
    <script src="{{ asset('js/filters.js') }}"></script>
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection

