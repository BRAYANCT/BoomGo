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
            </div><!--/col-->
            <div class="col-12">

                <admin-business-payment-method
                    url-auth-mercado-pago-prop="{{ MercadoPagoHelper::getUrlAuthMarketPlace() }}"
                    :is-admin-business-prop="@json($isAdminBusiness)"
                    business-id-prop="{{ isset($business) ? $business->id  : '' }}"
                ></admin-business-payment-method>
            </div>
        </div><!--/row-->
    </div><!--/container-->
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
