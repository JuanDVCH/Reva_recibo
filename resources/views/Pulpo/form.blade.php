<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<form class="formulario-estilos" method="POST" action="{{ route('pulpo.store') }}" id="pulpoForm">
    @csrf
    <div class="form-group row g-3">
        <div class="form-group col-md-4">
            <label for="filterOrderNum">Filtrar por Número de Recibo</label>
            <input type="text" class="form-control" id="filterOrderNum">
        </div>

        <div class="form-group col-md-4">
            <label for="inputOrderNum">Número de recibo</label>
            <select class="form-control" name="order_num" id="inputOrderNum" required>
                <option disabled selected value="">Selecciona un recibo</option>
                @foreach ($recibos as $recibo)
                    <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="inputSku">Sku</label>
            <select class="form-control" name="sku" id="inputSku" required>
                <option value="" disabled selected>Seleccionar código del producto</option>
                <!-- Opciones del SKU se llenarán dinámicamente mediante JavaScript -->
            </select>
        </div>
    </div>



    <div class="form-group row g-3">
        <div class="form-group col-md-4">
            <label for="filterSupplier">Filtrar por Proveedor</label>
            <input type="text" class="form-control" id="filterSupplier">
        </div>
        <div class="form-group col-md-4">
            <label for="inputSupplierCode">Código de Proveedor</label>
            <select class="form-control" name="supplier_code" id="inputSupplierCode" required>
                <option value="" disabled selected>Seleccionar proveedor</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->code }}">{{ $supplier->code }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="deliveryDate">Fecha de Entrega:</label>
            <input type="date" name="delivery_date" class="form-control" required>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label for="notes">Notas:</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>

    <div class="form-group row g-2">
        <div class="col-md-6">
            <label for="requested_quantity">Peso Neto:</label>
            <input type="text" name="requested_quantity" id="pesoNeto" class="form-control" readonly>
        </div>

        <div class="col-md-6">
            <label for="criterium">Criterio:</label>
            <input type="text" name="criterium" class="form-control" required>
        </div>


    </div>

    <div class="form-group row g-2">
        <div class="col-md-6">
            <label for="merchantSlug">Comerciante:</label>
            <input type="text" name="merchant_slug" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="merchantChannelSlug">Canal del Comerciante:</label>
            <input type="text" name="merchant_channel_slug" class="form-control" required>
        </div>
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Crear</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </div>
</form>
<!-- Asegúrate de incluir jQuery en tu archivo HTML -->
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
                url: '{{ route('pulpo.obtener-skus') }}', // Ajusta el nombre de la ruta según sea necesario
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
        // Almacena las opciones originales del campo SKU
        var originalSkuOptions = $('#inputSku').html();

        // Maneja el cambio en el campo Número de recibo
        $('#inputOrderNum').on('change', function() {
            var selectedOrderNum = $(this).val();

            // Realiza una solicitud Ajax para obtener los SKUs relacionados con el número de recibo seleccionado
            $.ajax({
                url: '{{ route('pulpo.obtener-skus') }}',
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

        // Maneja el cambio en el campo SKU
        $('#inputSku').on('change', function() {
            var selectedSku = $(this).val();
            var selectedOrderNum = $('#inputOrderNum').val();

            // Realiza una solicitud Ajax para obtener el peso neto de los productos asociados al SKU y número de orden
            $.ajax({
                url: '{{ route('pulpo.obtener-peso-neto') }}',
                type: 'GET',
                data: {
                    orderNum: selectedOrderNum,
                    sku: selectedSku
                },
                success: function(data) {
                    // Actualiza el campo de peso neto con el valor obtenido
                    $('#pesoNeto').val(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>
