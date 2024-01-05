<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Etiqueta</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/imprimir.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Formato de Etiqueta</h5>
                <p class="card-text"><strong>Número de Orden:</strong> {{ $etiqueta->order_num }}</p>
                <p class="card-text"><strong>Código del Producto:</strong> {{ $etiqueta->sku }}</p>
                <p class="card-text"><strong>Descripción:</strong> {{ $etiqueta->description }}</p>
                <p class="card-text"><strong>Fecha:</strong> {{ $etiqueta->delivery_date }}</p>
                <p class="card-text"><strong>Origen:</strong> {{ $etiqueta->origin }}</p>
                <p class="card-text"><strong>Cantidad:</strong> {{ $etiqueta->amount }}</p>
                <p class="card-text"><strong>Peso:</strong> {{ $etiqueta->weight }}</p>
                <p class="card-text"><strong>Tipo:</strong> {{ $etiqueta->type }}</p>
                <p class="card-text"><strong>Contenido:</strong> {{ $etiqueta->content }}</p>
                <p class="card-text"><strong>Estado del Producto:</strong> {{ $etiqueta->product_status }}</p>
                <p class="card-text"><strong>Color:</strong> {{ $etiqueta->color }}</p>
                <p class="card-text">
                    <strong>Código de Barras:</strong>
                    <div class="d-flex align-items-center">
                        <div>{!! DNS1D::getBarcodeHTML($etiqueta->barcode, 'C128') !!}</div>
                        <div class="ml-2">{{ $etiqueta->barcode }}</div>
                    </div>
                </p>
            </div>
            <div class="rounded-img">
                <!-- Agrega la ruta correcta de tu logo -->
                <img src="img/logo_reva-01.png" class="img-fluid" alt="Logo">
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
