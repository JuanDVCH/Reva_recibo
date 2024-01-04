<div class="container mt-5">
    <form method="POST" action="{{ route('recibo.store') }}" class="formulario-estilos row g-3">
        @csrf
        <div class="col-md-6">
            <label for="inputdelivery_date" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="inputdelivery_date" name="delivery_date" required>
        </div>
        <div class="col-md-6">
            <label for="inputorigin" class="form-label">Origen</label>
            <input type="text" class="form-control" id="inputorigin" name="origin" required>
        </div>
        <div class="col-md-6">
            <label for="inputcustomer" class="form-label">Cliente</label>
            <select class="form-select" id="inputcustomer" name="customer" required>
                <option value="" disabled selected>Seleccione una opción</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" data-code="{{ $supplier->code }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-6">
            <label for="inputcode_customer" class="form-label">Código del cliente</label>
            <input type="text" class="form-control" id="inputcode_customer" name="code_customer" required readonly>
        </div>

        <div class="col-md-4">
            <label for="inputdriver" class="form-label">Nombre del conductor</label>
            <input type="text" class="form-control" id="inputdriver" name="driver" required>
        </div>
        <div class="col-md-4">
            <label for="inputplate" class="form-label">Placa del vehículo</label>
            <input type="text" class="form-control" id="inputplate" name="plate" required>
        </div>
        <div class="col-md-4">
            <label for="inputnum_vehicle" class="form-label">Número del vehículo</label>
            <input type="number" class="form-control" id="inputnum_vehicle" name="num_vehicle">
        </div>
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-success mx-2">Enviar</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    // Script para seleccionar automáticamente el código del cliente
    $(document).ready(function () {
        $('#inputcustomer').change(function () {
            var selectedCode = $(this).find(':selected').data('code');
            $('#inputcode_customer').val(selectedCode);
        });

        // Seleccionar automáticamente al cargar la página
        var selectedCode = $('#inputcustomer').find(':selected').data('code');
        $('#inputcode_customer').val(selectedCode);
    });
</script>
