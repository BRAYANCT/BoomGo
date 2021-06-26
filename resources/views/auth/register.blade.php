@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)


@section('content')
    <div class="container ">
        <div class="row justify-content-center ">
            <div class="col-12 col-lg-6">

                <div class="row border border-light p-4 p-md-5 mx-0">
                    <div class="col-12 p-0">

                        <form class="form-btn-loader" method="POST" action="{{ route('register') }}">
                            @csrf

                            <p class="h4 mb-4 text-center">Regístrate</p>

                            <div class="form-group">
                                <input id="names" type="text" class="form-control {{ ValidateForm::getValidClass($errors,'names') }}" name="names" value="{{ old('names') }}" required autocomplete="names"  placeholder="Ingrese sus nombres">
                                {!! ValidateForm::getErrorDiv($errors,'names') !!}
                            </div>

                            <div class="form-group">
                                <input id="surnames" type="text" class="form-control {{ ValidateForm::getValidClass($errors,'surnames') }}" name="surnames" value="{{ old('surnames') }}" required autocomplete="surnames"  placeholder="Ingrese sus apellidos">
                                {!! ValidateForm::getErrorDiv($errors,'surnames') !!}
                            </div>

                            <div class="form-group">
                                <input id="email" type="email" class="form-control {{ ValidateForm::getValidClass($errors,'email') }}" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Ingrese su email">
                                {!! ValidateForm::getErrorDiv($errors,'email') !!}
                            </div>

                            <div class="form-group">
                                <input id="password" type="password" class="form-control {{ ValidateForm::getValidClass($errors,'password') }}" name="password" required  placeholder="Ingrese su contraseña">
                                {!! ValidateForm::getErrorDiv($errors,'password') !!}
                                <small class="helper-text" >@lang('helper.user.password')</small>
                            </div>

                            <div class="form-group">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  required  placeholder="Confirme su contraseña">
                            </div>

                            <button class="btn btn-info btn-block my-4" type="submit">
                                <i class="{{ config('constant.icon.sign_in.class') }}"></i> Registrar
                            </button>

                            <div class="text-right mb-4">
                                <a href="{{ route('login') }}">
                                    <i class="fas fa-long-arrow-alt-left mr-2"></i>Regresar al login
                                </a>
                            </div>

                        </form>
                        <!-- Default form login -->
                    </div><!--/col-12-->

                </div><!--/row-->

            </div><!--/col-->

        </div><!--/row-->
    </div>
@endsection
