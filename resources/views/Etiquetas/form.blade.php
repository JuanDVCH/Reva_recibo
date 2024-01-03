<div class="container mt-5">
    <form class="formulario-estilos row g-3" id="etiquetaForm" method="POST" action="{{ route('etiqueta.store') }}" >
        @csrf

        <!-- Número de recibo -->
        <div class="col-md-4">
            <label for="inputnumrecibo" class="form-label">Número de recibo</label>
            <select class="form-control" name="order_num" id="inputnumrecibo" required>
                <option disabled selected>Seleccionar número de orden</option>
                @foreach ($recibos as $recibo)
                    <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                @endforeach
            </select>
            <div id="numreciboError" class="text-danger"></div>
        </div>

        <!-- Código del Producto -->
        <div class="col-md-4">
            <label for="inputcode_product">Código del Producto</label>
            <select class="form-control" name="sku" id="inputcode_product" required>
                <option disabled selected>Seleccionar Código</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->sku }}">{{ $producto->sku }}</option>
                @endforeach
            </select>
            <div id="codeError" class="text-danger"></div>
        </div>

        <!-- Descripción -->
        <div class="col-md-4">
            <label for="inputdescription" class="form-label">Descripción</label>
            <select class="form-control" name="description" id="inputdescription" required>
                <option value="" disabled selected>Seleccionar Descripción</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->description }}">{{ $producto->description }}</option>
                @endforeach
            </select>
            <div id="descripcionError" class="text-danger"></div>
        </div>

        <!-- Fecha -->
        <div class="col-md-4">
            <label for="inputdelivery_date" class="form-label">Fecha</label>
            <select class="form-control" name="delivery_date" id="inputdelivery_date" required>
                <option value="" disabled selected>Seleccionar Fecha</option>
                @foreach ($recibos as $recibo)
                    <option value="{{ $recibo->delivery_date }}">{{ $recibo->delivery_date }}</option>
                @endforeach
            </select>
            <div id="dateError" class="text-danger"></div>
        </div>

        <!-- Origen -->
        <div class="col-md-4">
            <label for="inputorigin" class="form-label">Origen</label>
            <select class="form-control" name="origin" id="inputorigin" required>
                <option value="" disabled selected>Seleccionar Origen</option>
                @foreach ($recibos as $recibo)
                    <option value="{{ $recibo->origin }}">{{ $recibo->origin }}</option>
                @endforeach
            </select>
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
                <option value="rigido_P">Rigido P</option>
                <option value="rigido_G">Rigido G </option>
                <option value="flexible_P">Flexible P </option>
                <option value="flexible_G">Flexible G </option>

            </select>
            <div id="typeError" class="text-danger"></div>
        </div>

        <!-- Contenido -->
        <div class="col-md-4">
            <label for="inputcontent" class="form-label">Contenido</label>
            <select class="form-control" name="content" id="inputcontent" required>
                <option value="aderezos">Aderezos </option>
                <option value="limpieza">Limpieza</option>
                <option value="otros">Otros</option>
            </select>
            <div id="contentError" class="text-danger"></div>
        </div>

        <!-- Estado del producto -->
        <div class="col-md-4">
            <label for="inputproduct_status" class="form-label">Estado del producto</label>
            <select class="form-control" name="product_status" id="inputproduct_status" required>
                <option value="sucio">Sucio</option>
                <option value="limpio">Limpio</option>
            </select>
            <div id="productStatusError" class="text-danger"></div>
        </div>

        <!-- Color -->
        <div class="col-md-4">
            <label for="inputcolor" class="form-label">Color</label>
            <select class="form-control" name="color" id="inputcolor" required>
                <option value="colores">Colores</option>
                <option value="neutro">Neutro</option>
                <option value="policolores">Policolores</option>
            </select>
            <div id="colorError" class="text-danger"></div>
        </div>
        <!-- código de barras -->
        <div class="col-md-4">
            <label for="inputbar_code" class="form-label">Código de Barras</label>
            <input type="text" class="form-control" id="inputbarcode" name="barcode" required>
            <div id="barcodeError" class="text-danger"></div>
        </div>
</div>



<!-- Botones -->
<div class="col-12 mt-3 text-center">
    <button type="submit" class="btn btn-success mx-2">Enviar</button>
    <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
</div>
</form>

</div>

