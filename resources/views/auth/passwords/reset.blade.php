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
            <form class="text-center border border-light p-5 form-btn-loader" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <p class="h4 mb-4">Restablecer la contraseña</p>

                <!-- Email -->
                <input id="email" type="email" class="form-control mb-4" name="email" value="{{old('email',$email) }}" required autocomplete="email" autofocus placeholder="Ingrese su email">

                @error('email')
                    <div class="d-flex justify-content-start mb-3">
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror

                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Ingrese su contraseña">

                <small class="form-text helper-text  text-left mb-4">
                        @lang('helper.user.password')
                </small>


                @error('password')
                    <div class="d-flex justify-content-start mb-3">
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror

                <input type="password" class="form-control mb-4" placeholder="Confirme su contraseña" name="password_confirmation" required autocomplete="new-password">

                <!-- Sign in button -->
                <button class="btn btn-info btn-block my-4" type="submit">
                    Restablecer
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
