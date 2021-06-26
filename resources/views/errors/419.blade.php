@extends(Auth::check() ? 'admin.layouts.admin-template' : 'web.layouts.web-template')

@section('title', __('Page Expired'))

@section('description', __('Page Expired'))

@section('content')
	<div class="container  d-flex justify-content-center ">
		<div class="row">
			<div class="col-md-12">

				<h3 class="font-weight-bold" >Lo sentimos la página ha expirado. Por favor vuelva a cargar.</h3>
                <h4 class="text-muted">
                	Error 419 - {{ __($exception->getMessage() ?: 'Page Expired') }}
                </h4>

                <p class="buttons">
                	<a href="{{ URL::previous() }}" class="btn btn-primary">
                		<i class="fas fa-redo-alt"></i> Recargar
                	</a>
                </p>

			</div>

		</div>
	</div>
@endsection

{{--
@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
 --}}
