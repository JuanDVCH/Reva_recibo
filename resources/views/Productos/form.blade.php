<div class="container mt-5">
    <form id="productoForm" method="POST" action="{{ route('productos.store') }}" class="formulario-estilos row g-3">
        @csrf
        <div class="col-md-4">
            <label for="inputCodigo" class="form-label">Código</label>
            <input type="text" class="form-control" id="inputCodigo" name="code_product" required>
            <div id="codigoError" class="text-danger"></div>
        </div>
        <div class="col-md-4">
            <label for="inputDescripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="inputDescripcion" name="description">
            <div id="descripcionError" class="text-danger"></div>
        </div>
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
            <input type="number" step="any" class="form-control" id="inputbruto" name="gross_weight">
            <div id="brutoError" class="text-danger"></div>
        </div>
        <div class="col-md-4">
            <label for="inputEmpaque" class="form-label">Peso de empaque</label>
            <input type="number" step="any" class="form-control" id="inputEmpaque" name="packaging_weight">
            <div id="empaqueError" class="text-danger"></div>
        </div>
        <div class="col-md-6">
            <label for="inputNeto" class="form-label">Peso neto</label>
            <input type="number" step="any" class="form-control" id="inputNeto" name="net_weight">
            <div id="netoError" class="text-danger"></div>
        </div>

        
        <div class="col-md-6">
            <label for="inputConsecutivo" class="form-label">Numero de recibo</label>
            <select class="form-control" name="orden_num" id="inputConsecutivo" required>
                <option disabled selected>Selecciona un recibo</option>
                @foreach ($recibos as $recibo)
                    <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                @endforeach
            </select>
            <div id="consecutivoError" class="text-danger"></div>
        </div>

        <div class="col-12 mt-3 text-center">
            <button type="button" onclick="validarFormulario()" class="btn btn-success mx-2">Enviar</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </form>

</div>

<script>
    function validarFormulario() {
        // Obtener los valores de los campos
        var codigo = document.getElementById('inputCodigo').value.trim();
        var descripcion = document.getElementById('inputDescripcion').value.trim();
        var umb = document.getElementById('inputumb').value.trim();
        var cantidad = document.getElementById('inputcantidad').value.trim();
        var bruto = document.getElementById('inputbruto').value.trim();
        var empaque = document.getElementById('inputEmpaque').value.trim();
        var neto = document.getElementById('inputNeto').value.trim();
        var consecutivo = document.getElementById('inputConsecutivo').value.trim();

        // Limpiar mensajes de error anteriores
        limpiarMensajesError();

        // Validar cada campo
        if (codigo === '') {
            mostrarError('codigoError', 'El código es requerido.');
            return;
        }

        if (descripcion === '') {
            mostrarError('descripcionError', 'La descripción es requerida.');
            return;
        }

        if (umb === '') {
            mostrarError('umbError', 'La unidad de medida básica es requerida.');
            return;
        }

        if (cantidad === '') {
            mostrarError('cantidadError', 'La cantidad es requerida.');
            return;
        }

        if (bruto === '') {
            mostrarError('brutoError', 'El peso bruto es requerido.');
            return;
        }

        if (empaque === '') {
            mostrarError('empaqueError', 'El peso de empaque es requerido.');
            return;
        }

        if (neto === '') {
            mostrarError('netoError', 'El peso neto es requerido.');
            return;
        }

        if (consecutivo === '') {
            mostrarError('consecutivoError', 'El número de recibo es requerido.');
            return;
        }

        document.getElementById('productoForm').submit();
    }

    function limpiarMensajesError() {
        var errores = document.querySelectorAll('.text-danger');
        errores.forEach(function(elemento) {
            elemento.innerText = '';
        });
    }

    function mostrarError(idCampoError, mensaje) {
        document.getElementById(idCampoError).innerText = mensaje;
    }
</script>
