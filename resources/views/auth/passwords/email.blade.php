@extends('web.layouts.web-template')

@section('title', $title)

@section('description','')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Default form login -->
            <form class="text-center border border-light p-5 form-btn-loader" method="POST" action="{{ route('password.email') }}">
                @csrf
                <p class="h4 mb-4">Restablecer la contraseña</p>

                <!-- Email -->

                <input id="email" type="email" class="form-control mb-4" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingrese su email">

                @error('email')
                    <div class="d-flex justify-content-start mb-3">
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror


                <!-- Sign in button -->
                <button class="btn btn-info btn-block my-4" type="submit">
                    Enviar link de recuperación
                </button>

                <div class="text-right">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-long-arrow-alt-left mr-2"></i>Regresar al login
                    </a>
                </div>

            </form>
            <!-- Default form login -->

        </div><!--/col-->
    </div><!--/row-->
</div>
@endsection
