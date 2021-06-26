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


		<form 	class="form-css-validate my-3 form-btn-loader"
				method='POST'
				enctype="multipart/form-data"
				action="{{ route($prefixRouteWeb.'profile.update') }}"
		>
			{{ csrf_field() }}

			@method('PUT')


			<div class="card card-form mb-3">
                <div class="card-header">
                    <h3 class="card-header-title">
                        Datos del usuario
                    </h3>
                </div>
				<div class="card-body">
					<div class="row">

						<div class="col-md-6 mb-3">
							<div class="row">

								<div class="col-md-6">
									<div class="md-form ">
										<input type="text" id="username" class="form-control" value="{{ $model-> username }}" disabled >
										<label for="username">Nombre de usuario</label>
									</div>
								</div>

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

								<admin-user-password
											tipo="2"
											:show="@json(filter_var(old('cambio_password',false), FILTER_VALIDATE_BOOLEAN))"
											:error-has="{{$errors -> has('password') ? 'true' : 'false'}}"
											error="{{ $errors -> first('password') }}"
											helper-password="@lang('helper.user.password')" >
								</admin-user-password>
							</div>
						</div>

						<div class="col-md-6">
							<admin-file-input-basic  url-image="{{ $model-> getUrlThumbnail('profile_picture',true,true) }}" ></admin-file-input-basic>
							{!! ValidateForm::getBasicErrorDiv($errors,'imagen') !!}
						</div>


					</div><!--/row-->
				</div><!--/card-body-->
			</div><!--/card-->

			<button class="{{ config('constant.button.update.class') }}" type="submit"  >
				<i class="{{ config('constant.icon.update.class') }} mr-1"></i>
				@lang('button.update')
			</button>

		</form>


      </div>
    </div>

  </div>
@endsection

@section('script')
	<script type="text/javascript">
	</script>
@endsection
