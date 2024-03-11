<div class="container mt-2">
    <form method="POST" action="{{ route('recibo.update', $recibo->id) }}" class="formulario-estilos row g-3">
        @csrf
        @method('PUT') <!-- Agrega el método PUT para indicar que es una solicitud de actualización -->

        <div class="col-md-6">
            <label for="inputdelivery_date" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="inputdelivery_date" name="delivery_date" value="{{ $recibo->delivery_date }}" required>
        </div>
        <div class="col-md-6">
            <label for="inputorigin" class="form-label">Origen</label>
            <input type="text" class="form-control" id="inputorigin" name="origin" value="{{ $recibo->origin }}">
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
                    @foreach ($suppliers as $supplierOption)
                        <option value="{{ $supplierOption->name }}" data-code="{{ $supplierOption->code }}" {{ $supplierOption->name === $recibo->customer ? 'selected' : '' }}>
                            {{ $supplierOption->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <label for="inputcode_customer" class="form-label">Código del cliente</label>
            <input type="text" class="form-control" id="inputcode_customer" name="code_customer" value="{{ $recibo->code_customer }}" required readonly>
        </div>
        <div class="col-md-4">
            <label for="inputdriver" class="form-label">Nombre del conductor</label>
            <input type="text" class="form-control" id="inputdriver" name="driver" value="{{ $recibo->driver }}" required>
        </div>
        <div class="col-md-4">
            <label for="inputplate" class="form-label">Placa del vehículo</label>
            <input type="text" class="form-control" id="inputplate" name="plate" value="{{ $recibo->plate }}" required>
        </div>
        <div class="col-md-4">
            <label for="inputnum_vehicle" class="form-label">Impronta</label>
            <input type="text" class="form-control" id="inputnum_vehicle" name="num_vehicle" value="{{ $recibo->num_vehicle }}">
        </div>
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn bg-teal-500 mx-2 text-white">Actualizar</button>
            <a href="{{ route('recibo.index') }}" class="btn btn-secondary mx-2">Cancelar</a>
        </div>
    </form>
</div>
