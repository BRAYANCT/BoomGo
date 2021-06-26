@extends(Auth::check() ? 'admin.layouts.admin-template' : 'web.layouts.web-template')

@section('title', __('Unauthorized'))

@section('description', __('Unauthorized'))

@section('content')
	<div class="container d-flex justify-content-center ">
		<div class="row">
			<div class="col-md-12">

				<h3 class="font-weight-bold" >Lo sentimos no está autorizado.</h3>
                <h4 class="text-muted">
                	Error 401 - {{ __($exception->getMessage() ?: 'Unauthorized') }}
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

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized')) --}}
