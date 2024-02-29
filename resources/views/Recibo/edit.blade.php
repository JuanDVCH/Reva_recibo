<!-- resources/views/Recibo/edit.blade.php -->

    <div class="modal-content" id="editModalContent">
        <div class="container mt-2">
            <form method="POST" action="{{ route('recibo.update', $recibo->id) }}" class="formulario-estilos row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label for="inputorigin" class="form-label">Origen</label>
                    <input type="text" class="form-control" id="inputorigin" name="origin" value="{{ $recibo->origin }}">
                </div>

                <!-- Otros campos similares al formulario de creación con valores prellenados -->

                <div class="col-md-6">
                    <label for="inputdriver" class="form-label">Conductor</label>
                    <input type="text" class="form-control" id="inputdriver" name="driver" value="{{ $recibo->driver }}">
                </div>

                <div class="col-md-6">
                    <label for="inputplate" class="form-label">Placa</label>
                    <input type="text" class="form-control" id="inputplate" name="plate" value="{{ $recibo->plate }}">
                </div>

                @if ($errors->any())
                    <div class="col-12 mt-3 alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-12 mt-3 text-center">
                    <button type="submit" class="btn btn-primary mx-2">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
