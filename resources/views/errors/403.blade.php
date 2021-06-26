
@extends('admin.layouts.admin-template')

@section('title', __('Forbidden'))

@section('description', __('Forbidden'))

@section('content')
	<div class="container d-flex justify-content-center ">
		<div class="row">
			<div class="col-md-12">

				<h3 class="font-weight-bold" >Lo sentimos no está autorizado.</h3>
                <h4 class="text-muted">
                	Error 403 - {{ __($exception->getMessage() ?: 'Forbidden') }}
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

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}
