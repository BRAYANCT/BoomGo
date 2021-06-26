
@extends(Auth::check() ? 'admin.layouts.admin-template' : 'web.layouts.web-template')

@section('title', __('Not Found'))

@section('description', __('Not Found'))

@section('content')
	<div class="container d-flex justify-content-center ">
		<div class="row">
			<div class="col-md-12">

				<h3 class="font-weight-bold" >Lo sentimos la página no existe.</h3>
                <h4 class="text-muted">
                	Error 404 - {{ __($exception->getMessage() ?: 'Not Found') }}
                </h4>

                <p class="buttons">
                	<a href="{{url('/')}}" class="btn btn-primary">
                		<i class="fa fa-home"></i> Ir a Inicio
                	</a>
                </p>

			</div>

		</div>
	</div>
@endsection


{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}
