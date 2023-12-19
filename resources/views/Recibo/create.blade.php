@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear formato de recibo</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('recibo.form', ['recibos' => $recibos])
            </div>
        </div>
    </div>
@endsection
