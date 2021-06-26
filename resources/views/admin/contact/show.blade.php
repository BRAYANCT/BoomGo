
@extends('admin.layouts.admin-template')

@section('title', $title)


@section('description','')

@section('header')

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h1 class="h2">{{ $title }}</h1>
                <hr>
                <a 	href="{{ route($prefixRouteWeb.'index') }}"
                      class="{{ config('constant.button.list.class') }}">
                    <i class="{{ config('constant.icon.list.class') }} mr-2"></i>
                    @lang('button.contact.list')
                </a>
            </div><!--/col-->

            <div class="col-12">

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Datos de contacto
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="created_at" value="{{ $model-> display_date_created_at }}" class="form-control " disabled  >
                                    <label for="created_at">Fecha de registro</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="hour_created_at" value="{{ $model-> display_hour_created_at }}" class="form-control " disabled  >
                                    <label for="hour_created_at">Hora de registro</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="names" value="{{ $model-> names }}" class="form-control " disabled  >
                                    <label for="names">Nombres</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="surnames" value="{{ $model-> surnames }}" class="form-control " disabled  >
                                    <label for="surnames">Apellidos</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="phone" value="{{ $model-> phone }}" class="form-control " disabled  >
                                    <label for="phone">Teléfono</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="email" value="{{ $model-> email }}" class="form-control " disabled  >
                                    <label for="email">Email</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="company_name" value="{{ $model-> company_name }}" class="form-control " disabled  >
                                    <label for="company_name">Negocio</label>
                                </div>
                            </div>

                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->

            </div><!--/col-->
        </div><!--/row-->
    </div><!--/container-->
@endsection


