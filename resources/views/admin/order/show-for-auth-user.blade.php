
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
                <a 	href="{{ route('admin.orders.auth_user.index') }}"
                      class="{{ config('constant.button.list.class') }}">
                    <i class="{{ config('constant.icon.list.class') }} mr-2"></i>
                    Mis compras
                </a>
            </div><!--/col-->

            <div class="col-12">

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Datos del pedido
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="created_at" value="{{ $model-> display_date_created_at }}" class="form-control " disabled  >
                                    <label for="created_at">Fecha de registro</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="hour_created_at" value="{{ $model-> display_hour_created_at }}" class="form-control " disabled  >
                                    <label for="hour_created_at">Hora de registro</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="code" value="{{ $model-> getCode(true) }}" class="form-control " disabled  >
                                    <label for="code">Código</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="order_state" value="{{ $model-> orderState-> name }}" class="form-control " disabled  >
                                    <label for="order_state">Estado</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="business_name" value="{{ $model-> business-> name }}" class="form-control " disabled  >
                                    <label for="business_name">Negocio</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="user_full_name" value="{{ $model-> user->full_name }}" class="form-control " disabled  >
                                    <label for="user_full_name">Nombres del usuario</label>
                                </div>
                            </div>

                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Detalle de facturación
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_names" value="{{ $model-> billingInformation->names }}" class="form-control " disabled  >
                                    <label for="billingInformation_names">Nombres</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_surnames" value="{{ $model-> billingInformation->surnames }}" class="form-control " disabled  >
                                    <label for="billingInformation_surnames">Apellidos</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_email" value="{{ $model-> billingInformation->email }}" class="form-control " disabled  >
                                    <label for="billingInformation_email">Email</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_phone" value="{{ $model-> billingInformation->phone }}" class="form-control " disabled  >
                                    <label for="billingInformation_phone">Teléfono</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_department" value="{{ $model-> billingInformation->district->province->department->name }}" class="form-control " disabled  >
                                    <label for="billingInformation_department">Departamento</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_province" value="{{ $model-> billingInformation->district->province->name }}" class="form-control " disabled  >
                                    <label for="billingInformation_province">Provincia</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_district" value="{{ $model-> billingInformation->district->name }}" class="form-control " disabled  >
                                    <label for="billingInformation_district">Distrito</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="md-form ">
                                    <input type="text" id="billingInformation_address" value="{{ $model-> billingInformation->address }}" class="form-control " disabled  >
                                    <label for="billingInformation_address">Dirección</label>
                                </div>
                            </div>

                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->

                <div class="card card-form mb-3">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            Detalle de la compra
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive text-nowrap">
                                    <div>
                                        <table class="table table-striped table-hover  table-bordered dt-responsive nowrap">
                                            <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($model-> items as $element)
                                                <tr>
                                                    <td>{{ $element-> name }}</td>
                                                    <td>{{ $element-> quantity }}</td>
                                                    <td>{{ $element-> price }}</td>
                                                    <td>{{ $element-> total }}</td>
                                                </tr>
                                            @endforeach

                                            <td colspan="3" class="text-right">
                                                <span class="font-weight-bold h5">Envío</span>
                                            </td>
                                            <td>{{ $model-> shipping_price }}</td>
                                            <tr>
                                                <td colspan="3" class="text-right">
                                                    <span class="font-weight-bold h5">Total</span>
                                                </td>
                                                <td>{{ $model-> total }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div><!--/table-responsive-->
                            </div><!--/col-->
                        </div><!--/row-->
                    </div><!--/card-body-->
                </div><!--/card-->


            </div>
        </div><!--/row-->
    </div><!--/container-->
@endsection

@section('script')
@endsection
