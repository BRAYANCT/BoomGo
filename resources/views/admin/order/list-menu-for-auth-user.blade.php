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
            </div><!--/col-->
        </div><!--/row-->

        <div class="row my-5 justify-content-center">

            <div class="col-12 col-md-6">

                <div class="card card-my-account mb-3">
                    <a href="{{ route('admin.orders.auth_user.index') }}" title="Ver todos los pedidos">
                        <div class="card-header p-3">
                            <p class="m-0">
                                <i class="{{ config('constant.icon.orders.class') }}"></i>
                                Pedidos
                                <i class="{{ config('constant.icon.right_arrowhead.class') }} icon-arrow "></i>
                            </p>
                        </div>
                    </a>

                    <div class="card-body ">
                        <a href="{{ route('admin.orders.auth_user.index',['order_state_id'=>OrderStateHelper::getConstantId('OUTSTANDING_ID')]) }}" title="Ver los pedidos pendientes">
                            <p class="ml-2 mb-3">
                                Pendientes de pago
                                <i class="{{ config('constant.icon.right_arrowhead.class') }} icon-arrow "></i>
                            </p>
                        </a>

                        <a href="{{ route('admin.orders.auth_user.index',['order_state_id'=>OrderStateHelper::getConstantId('PAY_OUT_ID')]) }}" title="Ver los pedidos pagados">
                            <p class="ml-2 mb-3">
                                Pagados
                                <i class="{{ config('constant.icon.right_arrowhead.class') }} icon-arrow "></i>
                            </p>
                        </a>

                        <a href="{{ route('admin.orders.auth_user.index',['order_state_id'=>OrderStateHelper::getConstantId('DELIVERED_ID')]) }}" title="Ver los pedidos entregados">
                            <p class="ml-2 mb-3">
                                Entregados
                                <i class="{{ config('constant.icon.right_arrowhead.class') }} icon-arrow "></i>
                            </p>
                        </a>

                        <a href="{{ route('admin.orders.auth_user.index',['order_state_id'=>OrderStateHelper::getConstantId('CANCELLED_ID')]) }}" title="Ver los pedidos cancelados">
                            <p class="ml-2 mb-3">
                                Cancelados
                                <i class="{{ config('constant.icon.right_arrowhead.class') }} icon-arrow "></i>
                            </p>
                        </a>
                    </div>

                </div><!--/card-->
            </div><!--/col-->
        </div><!--/row-->

    </div><!--/container-->
@endsection


