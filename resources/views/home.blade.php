@extends('layouts.app')

@section('content')

    <section class="pt-4">
        <div class="container px-lg-5">
            <!-- Page Features-->
            <div class="row gx-lg-5">
                <div class="col-lg-6 col-xxl-4 mb-5">
                    <div class="card bg-light border-1 h-100">
                        <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i
                                    class="bi bi-collection"></i></div>
                            <h2 class="fs-4 fw-bold"> Formato de recibo</h2>

                            <a href="{{ route('recibo.index') }}" class="btn btn-dark">ir</a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-4 mb-5">
                    <div class="card bg-ligth border-1 h-100">
                        <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i
                                    class="bi bi-collection"></i></div>
                            <h2 class="fs-4 fw-bold">Formato de etiqueta</h2>
                            <a href="{{ route('etiqueta.index') }}" class="btn btn-dark">ir</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-4 mb-5">
                    <div class="card bg-ligth border-1 h-100">
                        <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i
                                    class="bi bi-collection"></i></div>
                            <h2 class="fs-4 fw-bold">Formato de recibo pulpo wms</h2>
                            <a href="{{ route('pulpo.index') }}" class="btn btn-dark">ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
