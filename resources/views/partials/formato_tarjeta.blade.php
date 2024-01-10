<div class="card bg-light border-1 h-100">
    <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4">
            <i class="bi bi-collection"></i>
        </div>
        <h2 class="fs-4 fw-bold"> Formato de {{ ucfirst($formato) }}</h2>
        <a href="{{ route($formato . '.index') }}" class="btn btn-dark">ir</a>
    </div>
</div>
