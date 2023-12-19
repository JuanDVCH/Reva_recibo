<!-- resources/views/pulpo/_form.blade.php -->

<form method="POST" action="{{ route('pulpo.store') }}" id="pulpoForm">
    @csrf
    <div class="col-md-12">
        <label for="inputOrderNum">Número de recibo</label>
        <select class="form-control" name="orden_num" id="inputOrderNum" required>
            <option disabled selected value="">Selecciona un recibo</option>
            @foreach ($recibos as $recibo)
                <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
            @endforeach
        </select>
    </div>
    <div class="row g-2">
        <div class="col-md-6">
            <label for="supplierCode">Código de Proveedor:</label>
            <input type="text" name="supplier_code" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="deliveryDate">Fecha de Entrega:</label>
            <input type="date" name="delivery_date" class="form-control" required>
        </div>
    </div>

    <div class="col-md-12">
        <label for="notes">Notas:</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label for="sku">SKU:</label>
            <input type="text" name="sku" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="requestedQuantity">Cantidad Solicitada:</label>
            <input type="number" name="requested_quantity" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="criterium">Criterio:</label>
            <input type="text" name="criterium" class="form-control">
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md-6">
            <label for="merchantSlug">Comerciante:</label>
            <input type="text" name="merchant_slug" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="merchantChannelSlug">Canal del Comerciante:</label>
            <input type="text" name="merchant_channel_slug" class="form-control" required>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Crear</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </div>
</form>
<script>

    </script>