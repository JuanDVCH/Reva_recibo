@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-4xl font-semibold text-white"><i class="fas fa-list-alt"></i>
                    Formatos de etiqueta
                </h3>
                <div class="flex">

                    <button type="button" class="btn btn-outline-light btn-lg rounded-pill mr-2" data-bs-toggle="modal"
                        data-bs-target="#createTagsModal">
                        Crear etiqueta <i class="fas fa-plus"></i>
                    </button>
                    <a href="{{ route('Receipts.recibo.index') }}" class="btn btn-outline-light btn-lg rounded-pill">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>

            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="w-full table table-bordered table-striped table-hover" id="etiquetaTable">
                        <thead class="bg-teal text-white">
                            <tr>
                                <th>Consecutivo</th>
                                <th>Número de Orden</th>
                                <th>Código del Producto</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Cantidad</th>
                                <th>Peso</th>
                                <th>Tipo</th>
                                <th>Contenido</th>
                                <th>Estado del Producto</th>
                                <th>Color</th>
                                <th>Código de Barras</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($etiquetas as $etiqueta)
                                <tr>
                                    <td>{{ $etiqueta->id_tag }}</td>
                                    <td>{{ $etiqueta->order_num }}</td>
                                    <td>{{ $etiqueta->sku }}</td>
                                    <td>{{ $etiqueta->description }}</td>
                                    <td>{{ $etiqueta->delivery_date }}</td>
                                    <td>{{ $etiqueta->customer }}</td>
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
                                            class="btn bg-teal-500 text-white">Imprimir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title">Vista previa del PDF</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePdfModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" width="100%" height="600px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createTagsModal" tabindex="-1" role="dialog" aria-labelledby="createTagsModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h1 class="text-2xl text-white font-semibold">Crear nueva etiqueta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('Receipts.etiquetas.form')
                </div>
            </div>
        </div>
    </div>
@endsection
