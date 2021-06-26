
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
                @if(!empty($model-> id))
                    <a href="{{ route($prefixRouteWeb.'create') }}" class="{{ config('constant.button.create.class') }}">
                        <i class="{{ config('constant.icon.create.class') }} mr-2"></i>
                        @lang('button.create')
                    </a>
                @endif
                <a 	href="{{ route($prefixRouteWeb.'index') }}"
                      class="{{ config('constant.button.list.class') }}">
                    <i class="{{ config('constant.icon.list.class') }} mr-2"></i>
                    @lang('button.product.list')
                </a>
            </div><!--/col-->

            <div class="col-12">
                <admin-product-form
                    id-prop="{{ $model->id }}"
                    :is-admin-business-prop="@json($isAdminBusiness)"
                ></admin-product-form>
            </div>
        </div><!--/row-->
    </div><!--/container-->
@endsection

@section('script')
@endsection
