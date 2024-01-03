<div class="container mt-5">
    <form id="productoForm" method="POST" action="{{ route('productos.store') }}" class="formulario-estilos row g-3">
        @csrf
        <div class="col-md-6">
            <label for="inputConsecutivo" class="form-label">Número de recibo</label>
            <select class="form-control" name="orden_num" id="inputConsecutivo" required>
                <option disabled selected>Selecciona un recibo</option>
                @foreach ($recibos as $recibo)
                    <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                @endforeach
            </select>
            <div id="consecutivoError" class="text-danger"></div>
        </div>
        <div class="col-md-4">
            <label for="inputSku" class="form-label">SKU</label>
            <select class="form-control" id="inputSku" name="sku" required>
                <option value="" disabled selected>Seleccionar SKU</option>
                @foreach ($skus as $sku)
                    <option value="{{ $sku }}">{{ $sku }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="inputDescripcion" class="form-label">Descripción</label>
            <select class="form-control" id="inputDescripcion" name="description" disabled>
                <option value="" selected>Selecciona un SKU primero</option>
            </select>
            <div id="descripcionError" class="text-danger"></div>
        </div>
        <!-- Campo oculto para almacenar la descripción -->

        <div class="col-md-4">
            <label for="inputumb" class="form-label">Unidad de medida básica</label>
            <input type="text" class="form-control" id="inputumb" name="unit_measurement">
            <div id="umbError" class="text-danger"></div>
        </div>
        <div class="col-md-4">
            <label for="inputcantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="inputcantidad" name="amount">
            <div id="cantidadError" class="text-danger"></div>
        </div>
        <div class="col-md-4">
            <label for="inputbruto" class="form-label">Peso Bruto</label>
            <input type="number" step="any" class="form-control" id="inputbruto" name="gross_weight"
                oninput="actualizarPesoNeto()">
            <div id="brutoError" class="text-danger"></div>
        </div>

        <div class="col-md-6">
            <label for="inputEmpaque" class="form-label">Peso de empaque</label>
            <input type="number" step="any" class="form-control" id="inputEmpaque" name="packaging_weight"
                oninput="actualizarPesoNeto()">
            <div id="empaqueError" class="text-danger"></div>
        </div>
        <div class="col-md-6">
            <label for="inputNeto" class="form-label">Peso neto</label>
            <label id="resultadoNeto" class="form-control"></label>
            <div id="netoError" class="text-danger"></div>
            <!-- Campo oculto para almacenar el valor del peso neto -->
            <input type="hidden" name="net_weight" id="inputNeto">
        </div>
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-success mx-2" id="enviarBtn">Enviar</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </form>
</div>

    
    <!-- Script JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputSku').on('input', function() {
                var sku = $(this).val().trim();
                var $descripcionSelect = $('#inputDescripcion');
    
                if (sku !== '') {
                    // Obtener el token CSRF
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
                    // Solicitud Ajax al controlador
                    $.ajax({
                        url: '{{ route("obtenerDescripcionPorSku") }}',
                        method: 'POST',
                        data: {
                            sku: sku,
                            _token: csrfToken
                        },
                        success: function(response) {
                            var descripcion = response.descripcion;
    
                            // Habilitar el select y actualizar opciones
                            $descripcionSelect.prop('disabled', false);
                            $descripcionSelect.html('<option value="' + descripcion + '" selected>' + descripcion + '</option>');
                        },
                        error: function() {
                            // Manejar el error si es necesario
                            $descripcionSelect.prop('disabled', true).html('<option value="" selected>Error al obtener la descripción</option>');
                        }
                    });
                } else {
                    // Si no hay SKU, deshabilitar el select y mostrar un mensaje predeterminado
                    $descripcionSelect.prop('disabled', true).html('<option value="" selected>Selecciona un SKU primero</option>');
                }
            });
        });
    </script>
<script>
    function actualizarPesoNeto() {
        // Actualizar peso neto
        var bruto = parseFloat($('#inputbruto').val()) || 0;
        var empaque = parseFloat($('#inputEmpaque').val()) || 0;

        var pesoNeto = bruto + empaque;
        $('#resultadoNeto').text(pesoNeto.toFixed(2));

        // Asignar valor al campo oculto
        $('#inputNeto').val(pesoNeto.toFixed(2));
    }
</script>