<!-- Incluye los estilos de Tailwind CSS en tu proyecto -->
<div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow-md">

    <form class="form-styles" method="POST" action="{{ route('pulpo.store') }}" id="pulpoForm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="inputFiltrarOrderNum" class="block text-sm font-medium text-gray-600">Filtrar por Número de
                    Recibo</label>
                <input type="number" class="form-input" id="inputFiltrarOrderNum" placeholder="Buscar recibo">
            </div>
            <div class="mb-4">
                <label for="inputOrderNum" class="block text-sm font-medium text-gray-600">Número de recibo</label>
                <select class="form-select" name="order_num" id="inputOrderNum" required>
                    <option disabled selected value="">Selecciona un recibo</option>
                    @foreach ($recibos as $recibo)
                        <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="filterSupplier" class="block text-sm font-medium text-gray-600">Filtrar por
                    Proveedor</label>
                <input type="text" class="form-input" id="filterSupplier">
            </div>

            <div class="mb-4">
                <label for="inputSupplierCode" class="block text-sm font-medium text-gray-600">Código de
                    Proveedor</label>
                <select class="form-select" name="supplier_code" id="inputSupplierCode" required>
                    <option value="" disabled selected>Seleccionar proveedor</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->code }}">{{ $supplier->code }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="mb-4">
                <label for="deliveryDate" class="block text-sm font-medium text-gray-600">Fecha de Entrega:</label>
                <input type="date" name="delivery_date" class="form-input" required>
            </div>
            <div class="mb-4">
                <label for="inputSku" class="block text-sm font-medium text-gray-600">SKU</label>
                <select class="form-select" name="sku" id="inputSku" required>
                    <!-- Opciones del SKU se llenarán dinámicamente mediante JavaScript -->
                </select>
            </div>
            <div class="mb-4">
                <label for="requested_quantity" class="block text-sm font-medium text-gray-600">Peso Neto:</label>
                <input type="text" name="requested_quantity" id="pesoNeto" class="form-input" readonly>
            </div>
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-600">Notas:</label>
            <textarea name="notes" class="form-input"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="mb-4">
                <label for="criterium" class="block text-sm font-medium text-gray-600">Criterio:</label>
                <input type="text" name="criterium" class="form-input" required>
            </div>
            <div class="mb-4">
                <label for="merchantSlug" class="block text-sm font-medium text-gray-600">Comerciante:</label>
                <input type="text" name="merchant_slug" class="form-input" required>
            </div>
            <div class="mb-4">
                <label for="merchantChannelSlug" class="block text-sm font-medium text-gray-600">Canal del
                    Comerciante:</label>
                <input type="text" name="merchant_channel_slug" class="form-input" required>
            </div>
        </div>

        <div class="button-container">
            <button type="submit" class="btn-submit">Crear</button>
            <button type="reset" class="btn-clear ml-2">Limpiar</button>
        </div>

    </form>
</div>

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

        // Evento para el filtrado de opciones del select de proveedores
        $('#filterSupplier').on('input', function() {
            var filterValue = $(this).val().toLowerCase();

            // Filtrar opciones del select de proveedores
            $('#inputSupplierCode option').filter(function() {
                var optionText = $(this).text().toLowerCase();
                $(this).toggle(optionText.indexOf(filterValue) > -1);
            });
        });

        $('#inputFiltrarOrderNum').on('input', function() {
            var filtroOrderNum = $(this).val().trim().toLowerCase();
            var $selectOrderNum = $('#inputOrderNum');

            // Filtrar opciones del select
            $selectOrderNum.find('option').filter(function() {
                var orderNum = $(this).text().toLowerCase();
                $(this).toggle(orderNum.indexOf(filtroOrderNum) > -1);
            });

            // Si hay solo una opción después del filtrado, seleccionarla automáticamente
            var opcionesVisibles = $selectOrderNum.find('option:visible');
            if (opcionesVisibles.length === 1) {
                opcionesVisibles.prop('selected', true);
            }
        });

    });
</script>
