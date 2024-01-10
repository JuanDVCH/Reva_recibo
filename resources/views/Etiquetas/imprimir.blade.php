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

    <div class="container">
        <div class="card">
            <div class="col-md-4">
                <img src="img/logo_reva-01.png" class="img-fluid" alt="Logo">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Formato de Etiqueta</h5>
                    <p class="card-text strong-text">Número de Orden: <span>{{ $etiqueta->order_num }}</span></p>
                    <p class="card-text strong-text">Código del Producto: <span>{{ $etiqueta->sku }}</span></p>
                    <p class="card-text strong-text">Descripción: <span>{{ $etiqueta->description }}</span></p>
                    <p class="card-text strong-text">Fecha: <span>{{ $etiqueta->delivery_date }}</span></p>
                    <p class="card-text strong-text">Origen: <span>{{ $etiqueta->origin }}</span></p>
                    <p class="card-text strong-text">Cantidad: <span>{{ $etiqueta->amount }}</span></p>
                    <p class="card-text strong-text">Peso: <span>{{ $etiqueta->weight }}</span></p>
                    <p class="card-text strong-text">Tipo: <span>{{ $etiqueta->type }}</span></p>
                    <p class="card-text strong-text">Contenido: <span>{{ $etiqueta->content }}</span></p>
                    <p class="card-text strong-text">Estado del Producto: <span>{{ $etiqueta->product_status }}</span></p>
                    <p class="card-text strong-text">Color: <span>{{ $etiqueta->color }}</span></p>
                    <div class="barcode-container">
                        <div class="barcode-image">
                            {!! DNS1D::getBarcodeHTML($etiqueta->barcode, 'C128') !!}
                        </div>
                        <div class="barcode-text">{{ $etiqueta->barcode }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


