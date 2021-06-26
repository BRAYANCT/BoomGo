
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
                    @lang('button.claim.list')
                </a>
            </div><!--/col-->

            <div class="col-12">

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Datos del cliente
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">

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
                                    <input type="text" id="document_type_id" value="{{ $model-> documentType->name }}" class="form-control " disabled  >
                                    <label for="document_type_id">Doc. Identidad</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="identification_document" value="{{ $model-> identification_document }}" class="form-control " disabled  >
                                    <label for="identification_document">Número doc.</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="phone" value="{{ $model-> phone }}" class="form-control " disabled  >
                                    <label for="phone">Teléfono fijo/Celular</label>
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
                                    <input type="text" id="department" value="{{ $model-> district->province->department->name }}" class="form-control " disabled  >
                                    <label for="department">Departamento</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="province" value="{{ $model->district->province->name }}" class="form-control " disabled  >
                                    <label for="province">Provincia</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="district" value="{{ $model->district->name }}" class="form-control " disabled  >
                                    <label for="district">Distrito</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="address" value="{{ $model-> address }}" class="form-control " disabled  >
                                    <label for="address">Dirección</label>
                                </div>
                            </div>

                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Datos del tutor
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="tutor_full_name" value="{{ $model-> tutor_full_name }}" class="form-control " disabled  >
                                    <label for="tutor_full_name">Nombre completo</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="tutor_email" value="{{ $model-> tutor_email }}" class="form-control " disabled  >
                                    <label for="tutor_email">Email</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="tutor_document_type_id" value="{{ $model-> tutorDocumentType ? $model-> tutorDocumentType->name : ''}}" class="form-control " disabled  >
                                    <label for="tutor_document_type_id">Doc. Identidad</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="tutor_identification_document" value="{{ $model-> tutor_identification_document }}" class="form-control " disabled  >
                                    <label for="tutor_identification_document">Número doc.</label>
                                </div>
                            </div>

                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Datos del reclamo
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
                                    <input type="text" id="code" value="{{ $model-> code }}" class="form-control " disabled  >
                                    <label for="code">Código</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="claim_type" value="{{ $model-> claim_type }}" class="form-control " disabled  >
                                    <label for="claim_type">Tipo</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-form ">
                                    <input type="text" id="related_claim" value="{{ $model-> related_claim }}" class="form-control " disabled  >
                                    <label for="related_claim">Relacionado a</label>
                                </div>
                            </div>

                            <div class="col-12 ">
                                <div class="form-group md-style">
                                    <label>Detalle del reclamo / Queja, según indica el cliente</label>
                                    <p class="bg-input-disabled">{{ $model-> detail_claims }}</p>
                                </div>
                            </div>

                            <div class="col-12 ">
                                <div class="form-group md-style">
                                    <label>Pedido del cliente</label>
                                    <p class="bg-input-disabled">{{ $model-> client_request }}</p>
                                </div>
                            </div>



                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->






            </div><!--/col-->
        </div><!--/row-->
    </div><!--/container-->
@endsection


