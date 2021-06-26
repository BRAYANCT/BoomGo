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

                <admin-shipping-form-list
                    :is-admin-business-prop="@json($isAdminBusiness)"
                ></admin-shipping-form-list>

            </div><!--/col-->
        </div><!--/row-->
    </div><!--/container-->
@endsection

@section('script')
    <script type="text/javascript">


    </script>
@endsection
