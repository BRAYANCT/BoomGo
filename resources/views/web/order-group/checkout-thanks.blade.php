
@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

    <section class="container">
        <div class="row">

            <div class="col-md-12">
                <h1 class="h2 mb-4">
                    Su compra se realizó con éxito.<br> A continuacion le mostramos el resumen de su(s) pedido(s).
                </h1>
            </div><!--/col-->

            <div class="col-12 mb-3">
                @foreach($orderGroup->orders as $order)

                    @if($order->paymentMethod->isWireTransfer())
                        @php
                            $businessPaymentMethod = $order->getBusinessPaymentMethod();
                        @endphp
                        <h5 class="h4">Transferencia Bancaria (Instrucciones):</h5>
                        <p>{{ $businessPaymentMethod->instructions }}</p>
                        <div class="table-responsive text-nowrap">
                            <div>
                                <table class="table table-striped table-hover  table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th>Nombre de la cuenta</th>
                                        <th>Número de cuenta</th>
                                        <th>Nombre del banco </th>
                                        <th>CCI </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($businessPaymentMethod->accountNumbers as $item)
                                    <tr >
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->account_number }}
                                        </td>
                                        <td>
                                            {{ $item->name_bank }}
                                        </td>
                                        <td>
                                            {{ $item->cci }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!--/table-responsive-->
                    @endif

                    @if($order->paymentMethod->isMercadoPago() || $order->paymentMethod->isUponDelivery())
                        <div class="alert alert-info mb-3">
                            Muchas gracias por tu compra en un máximo de 24 horas nos pondremos en contacto contigo.<br>
                            Para cualquier consulta puede comunicarse con nosotros a:<br>

                            Email: <a href="mailto:{{$order->business->email}}">{{ $order->business->email }}</a><br>

                            Teléfono: <a href="tel:{{$order->business->phone}}">{{ $order->business->phone }}</a><br>

                            @if($order->business->whatsapp)
                                Whatsapp: <a href="https://api.whatsapp.com/send?phone=51{{ $order->business->whatsapp }}">{{ $order->business->whatsapp }}</a><br>
                            @endif
                        </div>
                    @endif


                    <div class="card mb-3">
                        <div class="card-body">

                            <h5 class="h3 card-title">
                                <span class="font-weight-bold">Negocio:</span>
                                {{ $order->business->name }}
                            </h5>
                            <h5 class="h3 card-title">
                                <span class="font-weight-bold">Código de pedido:</span>
                                 {{ $order->code }}
                            </h5>

                            <h5 class="h3 card-title">
                                <span class="font-weight-bold">Estado:</span>
                                {!! $order->orderState->badge !!}
                            </h5>

                            <div class="table-responsive"  >
                                <table class="table product-table">

                                    <thead>
                                    <tr>
                                        <th width="160" ></th>
                                        <th>
                                            <span class="h4">Producto</span>
                                        </th>
                                        <th class="font-weight-bold">
                                            <span class="h4">Precio</span>
                                        </th>
                                        <th class="font-weight-bold">
                                            <span class="h4">Cantidad</span>
                                        </th>
                                        <th class="font-weight-bold">
                                            <span class="h4">Subtotal</span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td scope="row">
                                                <img  data-src="{{ $item->product->getUrlThumbnail('picture',true,true) }}" alt="{{  $item->name }}" class="img-fluid z-depth-0  lazy" width="150">
                                            </td>
                                            <td>
                                                <h5 class="h5">
                                                    <strong> {{ $item->name }}</strong>
                                                </h5>
                                            </td>
                                            <td>
                                                <span class="h6">S/ {{ $item->final_price }} </span>
                                                @if($item->offer_active)
                                                <p  class="h6 crossed-out-price mt-2 mb-0">
                                                    S/ {{ $item->price }}
                                                </p>
                                                @endif
                                            </td>
                                            <td class="text-center text-md-left">

                                                    <span class="d-flex align-items-center">

                                                        <span class="h6 mb-0 mx-2"  >
                                                            {{ $item->quantity }}
                                                        </span>

                                                    </span>

                                            </td>
                                            <td >
                                                <span class="font-weight-bold h6">
                                                    <strong>S/ {{ $item->sub_total }}</strong>
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-right" >
                                                <span class="h4 font-weight-bold">
                                                    Envío
                                                </span>
                                            </th>
                                            <th>
                                                <span class="h4 font-weight-bold">
                                                    S/ {{ $order->shipping_price }}
                                                </span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right" style="border:none" >
                                                <span class="h4 font-weight-bold">
                                                    Total
                                                </span>
                                            </th>
                                            <th style="border:none" >
                                                <span class="h4 font-weight-bold">
                                                    S/ {{ $order->total }}
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div><!--/table-responsive-->
                        </div><!--/card-body-->
                    </div><!--/card-->
                @endforeach

            </div><!--/col-->

            <div class="col-12">
                <a class="btn btn-secondary-custom btn-block">
                    <i class="{{ config('constant.icon.market_place.class') }}"></i> Volver a la tienda
                </a>
            </div>


        </div><!--/row-->
    </section><!--/container-->

@endsection

@section('script')

@endsection
