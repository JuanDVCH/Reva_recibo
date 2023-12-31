<div class="container mt-5">
    <form class="formulario-estilos row g-3" id="etiquetaForm" method="POST" action="{{ route('etiqueta.store') }}">
        @csrf

        <!-- Número de recibo -->
        <div class="form-group row g-2">
            <div class="form-group col-md-6">
                <label for="inputOrderNum">Número de recibo</label>
                <select class="form-control" name="order_num" id="inputOrderNum" required>
                    <option disabled selected value="">Selecciona un recibo</option>
                    @foreach ($recibos as $recibo)
                        <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputSku">Sku</label>
                <select class="form-control" name="sku" id="inputSku" required>
                    <option value="" disabled selected>Seleccionar código del producto</option>
                    <!-- Opciones del SKU se llenarán dinámicamente mediante JavaScript -->
                </select>
            </div>
        </div>

        <!--Descripción-->
        <div class="col-md-6">
            <label for="inputDescripcion" class="form-label">Descripción</label>
            <select class="form-control" id="inputDescripcion" name="description" disabled required>
                <option value="" selected>Selecciona un SKU primero</option>
            </select>
            <div id="descripcionError" class="text-danger"></div>
            <input type="hidden" name="hidden_description" id="hiddenDescripcion" required>
            <!-- Campo oculto para almacenar la descripción -->
            <input type="hidden" name="hidden_description" id="hiddenDescripcion" required>
        </div>

        <!-- Código de barras -->
        <div class="col-md-6">
            <label for="inputbar_code" class="form-label">Código de Barras</label>
            <input type="text" class="form-control" id="inputbarcode" name="barcode" required>
            <div id="barcodeError" class="text-danger"></div>
        </div>

        <!-- Fecha -->
        <div class="col-md-6">
            <label for="deliveryDate">Fecha:</label>
            <input type="date" name="delivery_date" class="form-control" required>
        </div>
        <!-- Origen -->
        <div class="col-md-6">
            <label for="inputorigin" class="form-label">Origen</label>
            <input type="text" name="origin" class="form-control" required>
            <div id="originError" class="text-danger"></div>
        </div>

        <!-- Amount -->
        <div class="col-md-4">
            <label for="inputamount" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="inputamount" name="amount">
            <div id="amountError" class="text-danger"></div>
        </div>

        <!-- Peso -->
        <div class="col-md-4">
            <label for="inputweight" class="form-label">Peso</label>
            <input type="number" step="any" class="form-control" id="inputweight" name="weight">
            <div id="weightError" class="text-danger"></div>
        </div>
        <!-- Tipo de producto -->
        <div class="col-md-4">
            <label for="inputtype" class="form-label">Tipo de producto</label>
            <select class="form-control" name="type" id="inputtype" required>
                <option value="" disabled selected>Seleccionar tipo de producto</option>
                <option value="rigido_P">Rigido P</option>
                <option value="rigido_G">Rigido G</option>
                <option value="flexible_P">Flexible P</option>
                <option value="flexible_G">Flexible G</option>
                <option value="No_aplica">No aplica</option>

            </select>
            <div id="typeError" class="text-danger"></div>
        </div>

        <!-- Contenido -->
        <div class="col-md-4">
            <label for="inputcontent" class="form-label">Contenido</label>
            <select class="form-control" name="content" id="inputcontent" required>
                <option value="" disabled selected>Seleccionar contenido</option>
                <option value="aderezos">Aderezos</option>
                <option value="limpieza">Limpieza</option>
                <option value="No_aplica">No aplica</option>

            </select>
            <div id="contentError" class="text-danger"></div>
        </div>

        <!-- Estado del producto -->
        <div class="col-md-4">
            <label for="inputproduct_status" class="form-label">Estado del producto</label>
            <select class="form-control" name="product_status" id="inputproduct_status" required>
                <option value="" disabled selected>Seleccionar estado del producto</option>
                <option value="sucio">Sucio</option>
                <option value="limpio">Limpio</option>
                <option value="No_aplica">No aplica</option>

            </select>
            <div id="productStatusError" class="text-danger"></div>
        </div>

        <!-- Color -->
        <div class="col-md-4">
            <label for="inputcolor" class="form-label">Color</label>
            <select class="form-control" name="color" id="inputcolor" required>
                <option value="" disabled selected>Seleccionar color</option>
                <option value="colores">Colores</option>
                <option value="neutro">Neutro</option>
                <option value="No_aplica">No aplica</option>

            </select>
            <div id="colorError" class="text-danger"></div>
        </div>


        <!-- Botones -->
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-success mx-2">Enviar</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </form>
</div>
<!-- Script JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Almacena las opciones originales del campo SKU
        var originalSkuOptions = $('#inputSku').html();

        // Maneja el cambio en el campo Número de recibo
        $('#inputOrderNum').on('change', function() {
            var selectedOrderNum = $(this).val();

            // Realiza una solicitud Ajax para obtener los SKUs relacionados con el número de recibo seleccionado
            $.ajax({
                url: '{{ route('etiqueta.obtener-skus') }}', // Ajusta el nombre de la ruta según sea necesario
                type: 'GET',
                data: {
                    orderNum: selectedOrderNum
                },
                success: function(data) {
                    // Limpia y llena el select de SKU con las opciones obtenidas
                    $('#inputSku').empty();
                    $('#inputSku').append(
                        '<option value="" disabled selected>Seleccionar código del producto</option>'
                    );
                    $.each(data, function(key, value) {
                        $('#inputSku').append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Evento para el cambio en el número de recibo
        $('#inputConsecutivo').on('change', function() {
            // ... (tu código existente)
        });

        // Evento para la entrada en el campo SKU
        $('#inputSku').on('change', function() {
            var sku = $(this).val().trim();
            var $descripcionSelect = $('#inputDescripcion');

            if (sku !== '') {
                // Obtener el token CSRF
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Solicitud Ajax al controlador
                $.ajax({
                    url: '{{ route('obtenerDescripcionPorSku') }}',
                    method: 'POST',
                    data: {
                        sku: sku,
                        _token: csrfToken
                    },
                    success: function(response) {
                        var descripcion = response.descripcion;

                        // Habilitar el select y actualizar opciones
                        $descripcionSelect.prop('disabled', false);
                        $descripcionSelect.html('<option value="' + descripcion +
                            '" selected>' + descripcion + '</option>');

                        // Almacenar la descripción en el campo oculto
                        $('#hiddenDescripcion').val(descripcion);
                    },
                    error: function() {
                        // Manejar el error si es necesario
                        $descripcionSelect.prop('disabled', true).html(
                            '<option value="" selected>Error al obtener la descripción</option>'
                            );
                    }
                });
            } else {
                // Si no hay SKU, deshabilitar el select y mostrar un mensaje predeterminado
                $descripcionSelect.prop('disabled', true).html(
                    '<option value="" selected>Selecciona un SKU primero</option>');
            }
        });

        // Botón Limpiar
        $('#limpiarBtn').on('click', function() {
            // Restablecer el formulario a su estado original
            $('#productoForm')[0].reset();

            // Ocultar mensajes de error
            $('#consecutivoError, #descripcionError, #umbError, #cantidadError, #brutoError, #empaqueError, #netoError')
                .text('');

            // Deshabilitar select de descripción
            $('#inputDescripcion').prop('disabled', true).html(
                '<option value="" selected>Selecciona un SKU primero</option>');

            // Restablecer el resultado de Peso Neto
            $('#resultadoNeto').text('');

            // Restablecer el valor del campo oculto de Peso Neto
            $('#inputNeto').val('');

            // Restablecer el valor del campo oculto de Descripción
            $('#hiddenDescripcion').val('');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Almacena las opciones originales del campo SKU
        var originalSkuOptions = $('#inputSku').html();

        // Botón Limpiar
        $('#etiquetaForm').on('reset', function() {
            // Restablecer el formulario a su estado original
            $('#inputSku').html(originalSkuOptions);

            // Ocultar mensajes de error
            $('.text-danger').text('');

            // Deshabilitar select de descripción
            $('#inputDescripcion').prop('disabled', true).html(
                '<option value="" selected>Selecciona un SKU primero</option>');
        });
    });
</script>