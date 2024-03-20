<div class="container mt-2">
    <form method="POST" action="{{ route('s_recibo.store') }}" class="formulario-estilos row g-3">
        @csrf
        <div class="col-md-6">
            <label for="inputdelivery_date" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="inputdelivery_date" name="delivery_date" required>
        </div>
        <div class="col-md-6 d-flex">
            <div class="me-2 flex-grow-1">
                <label for="customerFilter" class="form-label">Buscar</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="customerFilter" placeholder="Buscar clientes">
                </div>
            </div>
            <div class="flex-grow-1">
                <label for="customer" class="form-label">Seleccionar Cliente</label>
                <select class="form-select custom-select" id="customer" name="customer" style="width: 100%;" required>
                    <option value="" disabled selected>Seleccione un cliente</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->name }}" data-code="{{ $supplier->code }}">{{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <label for="inputcode_customer" class="form-label">Código del cliente</label>
            <input type="text" class="form-control" id="inputcode_customer" name="code_customer" required readonly>
        </div>
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn bg-teal-500 mx-2 text-white">Enviar</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </form>
</div>
<div id="alerta" class="hidden fixed top-0 left-0 w-full h-full flex justify-center items-center">
    <div class="bg-gray-900 bg-opacity-50 absolute w-full h-full"></div>
    <div class="bg-white rounded-lg p-6 shadow-lg relative">
        <button id="cerrarAlerta" class="absolute top-1 right-1 text-black hover:text-black-700 focus:outline-none">
            <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="flex items-center justify-center">
            <svg class="h-12 w-12 text-teal-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.293 14.293a1 1 0 0 1-1.414 0l-3-3a1 1 0 1 1 1.414-1.414L8 11.586l6.293-6.293a1 1 0 1 1 1.414 1.414l-7 7a1 1 0 0 1-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-800">¡Recibo creado con éxito!</h2>
        </div>
        <p class="text-gray-600 mt-2">El recibo se ha creado correctamente. Puedes revisarlo en la lista de recibos.</p>
        <button id="listoButton" class="mt-4 px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 focus:outline-none">Listo</button>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Evento para el filtrado de opciones del select
        $('#customerFilter').on('input', function() {
            var filterValue = $(this).val().toLowerCase();

            // Filtrar opciones del select
            $('#customer option').filter(function() {
                var optionText = $(this).text().toLowerCase();
                $(this).toggle(optionText.indexOf(filterValue) > -1);
            });
        });

        // Script para seleccionar automáticamente el código del cliente
        $('#customer').change(function() {
            var selectedCode = $(this).find(':selected').data('code');
            $('#inputcode_customer').val(selectedCode ||
                ''); // Manejo especial si no se selecciona ningún cliente
        });

        // Seleccionar automáticamente al cargar la página
        var selectedCode = $('#customer').find(':selected').data('code');
        $('#inputcode_customer').val(selectedCode || ''); // Manejo especial si no se selecciona ningún cliente
    });
</script>


<script>
    // Obtén la referencia al elemento de entrada de fecha
    var inputDeliveryDate = document.getElementById('inputdelivery_date');

    // Obtén la fecha actual en formato ISO (YYYY-MM-DD)
    var currentDate = new Date().toISOString().split('T')[0];

    // Establece la fecha máxima como la fecha actual
    inputDeliveryDate.setAttribute('max', currentDate);
</script>

<script>
    $(document).ready(function() {
        $('.formulario-estilos').submit(function(event) {
            // Evita que el formulario se envíe de forma predeterminada
            event.preventDefault();

            // Realiza la solicitud de creación del recibo utilizando AJAX
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    // Muestra la alerta de éxito
                    $('#alerta').removeClass('hidden');
                },
                error: function(xhr, status, error) {
                    // Manejo de errores si la creación del recibo falla
                    alert('Error al crear el recibo: ' + xhr.responseText);
                    // Puedes personalizar esta alerta según los errores que recibas
                }
            });
        });

        // Cierra la alerta al hacer clic en el botón de cerrar
        $('#cerrarAlerta').click(function() {
            $('#alerta').addClass('hidden');
        });

        // Agrega un evento al botón de "Listo" en la alerta
        $('#listoButton').click(function() {
            $('#alerta').addClass('hidden');
            // Recarga la página después de cerrar la alerta
            window.location.reload();
        });
    });
</script>
