<div class="container mt-5">
    <h2 class="text-center mb-4">Formato de recibo</h2>
    <form method="POST" action="{{ route('recibo.store') }}"   class="row g-3">
        @csrf
        <div class="col-md-6">
            <label for="inputdelivery_date" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="inputdelivery_date" name="delivery_date">
        </div>
        <div class="col-md-6">
            <label for="inputorigin" class="form-label">Origen</label>
            <input type="text" class="form-control" id="inputorigin" name="origin">
        </div>
        <div class="col-md-6">
            <label for="inputcustomer" class="form-label">Cliente</label>
            <input type="text" class="form-control" id="inputcustomer" name="customer">
        </div>
        <div class="col-md-6">
            <label for="inputcode_customer" class="form-label">Código del cliente</label>
            <input type="text" class="form-control" id="inputcode_customer" name="code_customer">
        </div>
        <div class="col-md-4">
            <label for="inputdriver" class="form-label">Nombre del conductor</label>
            <input type="text" class="form-control" id="inputdriver" name="driver">
        </div>
        <div class="col-md-4">
            <label for="inputplate" class="form-label">Placa del vehículo</label>
            <input type="text" class="form-control" id="inputplate" name="plate">
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
