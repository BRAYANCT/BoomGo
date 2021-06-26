@extends('admin.layouts.admin-template')


@section('title', $title)


@section('description','')

@section('header')

@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="h2">{{ $title }}</h1>
        <hr>
        @if(!empty($model-> id))
	        <a href="{{ route($prefixRouteWeb.'create') }}" class="{{ config('constant.button.create.class') }}">
	            <i class="{{ config('constant.icon.create.class') }} mr-2"></i>
	            @lang('button.create')
	        </a>
        @endif
		<a 	href="{{ route($prefixRouteWeb.'index') }}"
			class="{{ config('constant.button.list.class') }}">
			 <i class="{{ config('constant.icon.list.class') }} mr-2"></i>
			 @lang('button.user.list')
		</a>


		<form class="form-css-validate my-3 form-btn-loader" method='POST'  enctype="multipart/form-data"
			@if(empty($model-> id))
				action="{{ route($prefixRouteWeb.'store') }}"
			@else
				action="{{ route($prefixRouteWeb.'update',[$model]) }}"
			@endif
		>
			{{ csrf_field() }}

			@if(!empty($model-> id))
				@method('PUT')
			@endif


			<div class="card card-form mb-3">
                <div class="card-header">
                    <h3 class="card-header-title">
                        Datos del usuario
                    </h3>
                </div>

				<div class="card-body">
					<div class="row">

						@if(!empty($model->id))
							<div class="col-md-6">
								<div class="md-form ">
									<input type="text" id="username" class="form-control" value="{{ $model-> username }}" disabled >
									<label for="username">Nombre de usuario</label>
								</div>
							</div>
                            @if($model->business)
                            <div class="col-md-6">
                                <div class="md-form has-helper-text">
                                    <input type="text" id="business_name" class="form-control" value="{{ $model-> business-> name }}" disabled >
                                    <label for="business_name">Negocio</label>
                                </div>
                                @component('components.form.helper')
                                    <a href="{{ route('admin.businesses.edit',$model->business) }}">
                                        <i class="{{config('constant.icon.business.class')}} mr-2"></i>Editar el negocio
                                    </a>
                                @endcomponent
                            </div>
                            @endif
						@endif



						<div class="col-md-6">
							<div class="md-form ">
								<input type="text" id="names" name="names" value="{{ old('names',$model-> names) }}" class="form-control {{ ValidateForm::getValidClass($errors,'names') }}" required maxlength="{{ config('constant.attribute.names.max') }}">
								<label for="names">Nombres*</label>
								{!! ValidateForm::getErrorDiv($errors,'names') !!}
							</div>
						</div>

						<div class="col-md-6">
							<div class="md-form ">
								<input type="text" id="surnames" name="surnames" value="{{ old('surnames',$model-> surnames) }}" class="form-control {{ ValidateForm::getValidClass($errors,'surnames') }}"  required  maxlength="{{ config('constant.attribute.surnames.max') }}">
								<label for="surnames">Apellidos*</label>
								{!! ValidateForm::getErrorDiv($errors,'surnames') !!}
							</div>
						</div>


						<div class="col-md-6">
							<div class="md-form ">
								<input type="email" id="email" name="email" value="{{ old('email',$model-> email) }}" class="form-control {{ ValidateForm::getValidClass($errors,'email') }}" required maxlength="{{ config('constant.attribute.email.max') }}">
								<label for="email">Email*</label>
								{!! ValidateForm::getErrorDiv($errors,'email') !!}
							</div>
						</div>

						<div class="col-md-6 {{ ValidateForm::getValidClass($errors,'role_id') }}" >
								<select class="mdb-select init md-form colorful-select dropdown-primary" name="role_id" >
								  	<option value="">Seleccione</option>
								 	@foreach($roles as $role)

								 		@php
								 			$roleId = old('role_id');
								 			if($model->getRole()){
								 				$roleId = old('role_id',$model->getRole()->id);
								 			}
								 		@endphp

								  		<option value="{{ $role-> id }}" @if($roleId == $role-> id) selected @endif >{{ $role-> display_name }}</option>
								  	@endforeach
								</select>
								<label class="mdb-main-label active">Rol*</label>
								{!! ValidateForm::getErrorDiv($errors,'role_id') !!}
						</div>

						@if(!empty($model-> id))
						<div class="col-md-6 {{ ValidateForm::getValidClass($errors,'user_state_id') }}" >
							<select class="mdb-select init md-form colorful-select dropdown-primary" name="user_state_id">
							  	<option value="">Seleccione</option>
							 	@foreach($userStates as $item)

							 		@php
							 			$estadoUsuarioId = old('user_state_id',$model-> user_state_id);
							 		@endphp

							  		<option value="{{ $item-> id }}" @if($estadoUsuarioId == $item-> id) selected @endif >{{ $item-> name }}</option>
							  	@endforeach
							</select>
							<label class="mdb-main-label active">Estado usuario</label>
							{!! ValidateForm::getErrorDiv($errors,'user_state_id') !!}
						</div>
						@endif

						<admin-user-password
									tipo="{{ empty($model-> id) ? 1 : 2 }}"
									:show="@json(filter_var(old('cambio_password',false), FILTER_VALIDATE_BOOLEAN))"
									:error-has="{{$errors -> has('password') ? 'true' : 'false'}}"
									error="{{ $errors -> first('password') }}"
									helper-password="@lang('helper.user.password')" >
						</admin-user-password>

						@if(!empty($model-> id))
							<div class="col-md-12 mt-3">
								<admin-file-input-basic  url-image="{{ $model-> getUrlThumbnail('profile_picture',true,true) }}" ></admin-file-input-basic>
								{!! ValidateForm::getBasicErrorDiv($errors,'image') !!}
							</div>
						@endif


					</div><!--/row-->
				</div><!--/card-body-->
			</div><!--/card-->

			@if(empty($model-> id))
				<button class="{{ config('constant.button.store.class') }}" type="submit"  >
					<i class="{{ config('constant.icon.store.class') }} mr-1"></i>
					@lang('button.store')
				</button>
			@else
				<button class="{{ config('constant.button.update.class') }}" type="submit"  >
					<i class="{{ config('constant.icon.update.class') }} mr-1"></i>
					@lang('button.update')
				</button>

				<button id="btn-destroy"
						class="{{ config('constant.button.destroy.class') }}"
						type="button">
					<i class="{{ config('constant.icon.destroy.class') }} mr-1"></i>
					@lang('button.destroy')
				</button>
			@endif
		</form>

		@if(!empty($model-> id))
			<form id="form-destroy" action="{{ route($prefixRouteWeb.'destroy',[$model]) }}" method="POST" >
				@csrf
				@method('DELETE')
			</form>
		@endif

      </div>
    </div>

  </div>
@endsection

@section('script')
	<script type="text/javascript">
	</script>
@endsection
