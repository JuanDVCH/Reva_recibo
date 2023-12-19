<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Etiqueta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card {
            width: 400px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 15px;
            width: 100%;
        }

        .list-group-item {
            border: none;
            padding: 10px;
        }

        #qrcode-container {
            text-align: center;
            margin-top: 20px;
        }

        @media print {
            #qrcode-container img {
                display: block !important;
            }
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card border-primary">
            <div class="card-header">
                <h3>Formato de Etiqueta</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <!-- Ajusta las etiquetas según tus necesidades -->
                    <li class="list-group-item"><strong>Número de Orden:</strong> {{ $etiqueta->order_num }}</li>
                    <li class="list-group-item"><strong>Código del Producto:</strong> {{ $etiqueta->code_product }}</li>
                    <li class="list-group-item"><strong>Descripción:</strong> {{ $etiqueta->description }}</li>
                    <li class="list-group-item"><strong>Fecha:</strong> {{ $etiqueta->delivery_date }}</li>
                    <li class="list-group-item"><strong>Origen:</strong> {{ $etiqueta->origin }}</li>
                    <li class="list-group-item"><strong>Amount:</strong> {{ $etiqueta->amount }}</li>
                    <li class="list-group-item"><strong>Peso:</strong> {{ $etiqueta->weight }}</li>
                    <li class="list-group-item"><strong>Tipo:</strong> {{ $etiqueta->type }}</li>
                    <li class="list-group-item"><strong>Contenido:</strong> {{ $etiqueta->content }}</li>
                    <li class="list-group-item"><strong>Estado del Producto:</strong> {{ $etiqueta->product_status }}</li>
                    <li class="list-group-item"><strong>Color:</strong> {{ $etiqueta->color }}</li>

                </ul>
            </div>
        </div>
    </div>

    <script>
        // Agrega un script aquí si necesitas personalizar algo antes de imprimir
        // Por ejemplo, ocultar ciertos elementos o realizar ajustes específicos.
    </script>

</body>

</html>
