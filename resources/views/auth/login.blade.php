@extends('web.layouts.web-template')

@section('title', $title)

@section('description','')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">

            <!-- Default form login -->
            <form class="text-center border border-light p-5 form-btn-loader" method="POST" action="{{ route('login') }}">
                @csrf
                <p class="h4 mb-4">Inicio de sesión</p>

                <!-- Email -->

                <input id="email" type="text" class="form-control mb-4" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingrese su email">

                <input id="password" type="password" class="form-control mb-4" name="password" required autocomplete="current-password" placeholder="Ingrese su contraseña">

                @error('email')
                    <div class="d-flex justify-content-start mb-3">
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror

                <div class="d-flex justify-content-around">
                    <div>
                        <!-- Remember me -->
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="custom-control-label" for="remember">
                                Recuérdame
                            </label>
                        </div>
                    </div>
                    <div>
                        <!-- Forgot password -->
                        <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                    </div>
                </div>

                <!-- Sign in button -->
                <button class="btn btn-info btn-block my-4" type="submit">
                    <i class="{{ config('constant.icon.log_in.class') }}"></i> Iniciar sesión
                </button>

                <p class="mb-0">
                    ¿No eres miembro? <a href="{{ route('register') }}">Regístrate</a>
                </p>


            </form><!--/ Default form login -->

        </div><!--/col-->
    </div><!--/row-->
</div>
@endsection
