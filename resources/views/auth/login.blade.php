@extends('layouts.app')

@section('content')
<section class="d-flex justify-content-center align-items-center" style="background-color: #ffff;">
    <div class="container py-5">
        <div class="card border-0" style="border-radius: 1rem; background-color: #F2F2F2; overflow: hidden;">
            <div class="row g-0">
                <div class="col-md-6 col-lg-5 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('img/reva3.jpeg') }}" alt="formulario de inicio de sesión" class="img-fluid"
                        style="border-radius: 1rem 0 0 1rem; max-width: 100%;" />
                </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                    <div class="card-body p-4 p-lg-5 text-black">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="d-flex align-items-center mb-3 pb-1">
                                <i class="fas fa-cubes fa-2x me-3" style="color: #4EBFAB;"></i>
                                <span class="h1 fw-bold mb-0" style="color: #038C7F;">Reva</span>
                            </div>

                            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; color: #595959;">
                                Iniciar sesión</h3>

                            <div class="form-outline mb-4">
                                <input type="email" id="email" class="form-control form-control-lg" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    style="background-color: #F2F2F2; color: #595959;" />
                                <label class="form-label" for="email" style="color: #595959;">Correo
                                    electrónico</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" class="form-control form-control-lg"
                                    name="password" required autocomplete="current-password"
                                    style="background-color: #F2F2F2; color: #595959;" />
                                <label class="form-label" for="password" style="color: #595959;">Contraseña</label>
                            </div>

                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block" type="submit"
                                    style="background-color: #03A696;">Entrar</button>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember" style="color: #595959;">
                                            {{ __('Recordar contraseña') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-8 ">
                                    <a class="btn btn-link" href="{{ route('password.request') }}"
                                        style="color: #595959;">
                                        {{ __('¿Olvidó su contraseña?') }}
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
