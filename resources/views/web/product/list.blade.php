@php
    $classTagMain ="my-0";


    $orderText = "Últimos";

    if(Request::get('order')){
        $order = Request::get('order');
        if($order =="last"){
            $orderText = "Últimos";
        }else if($order =="higher_price"){
            $orderText = "Mayor precio";
        }else if($order =="lower_price"){
            $orderText = "Menor precio";
        }
    }


    $filtersActive = array();

    if(isset($category)){
        array_push($filtersActive,$category->name);
    }

    if(Request::get('search_text')){
        array_push($filtersActive,Request::get('search_text'));
    }

@endphp

@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-3 tertiary-custom-color">
            <aside class="tertiary-custom-color px-lg-3 px-xl-5  py-md-5 h-100 filters-business-list">

                @if(count($filtersActive)>0)
                    <h4 class="h5 text-secondary-custom mb-2">
                        {{ count($filtersActive) }} {{ count($filtersActive)==1 ? 'filtro' : 'filtros' }}
                    </h4>
                    <div class="small mb-3 text-white">
                        @foreach($filtersActive as $value)
                            <span>{{ $value }}</span> @if(!$loop->last)-@endif
                        @endforeach
                        <br>
                        <a href="{{ isset($business) ? route('products.businesses.by_slug',$business->slug) : route('products.index') }}" class="text-primary-custom">
                            <i class="{{config('constant.icon.delete.class')}}"></i> Borrar todo
                        </a>
                    </div>
                @endif

                <h3 class="h3 text-secondary-custom text-uppercase mb-4">Filtros</h3>

                <div class="mb-4">
                    <h4 class="h5 text-secondary-custom mb-3">Categorías</h4>
                    <web-category-list-product-filter
                        business-id-prop = "{{ isset($business) ? $business->id : '' }}"
                        business-slug-prop = "{{ isset($business) ? $business->slug : '' }}"
                        category-id-prop="{{ isset($category) ? $category->id : ''  }}"
                        class="pl-2"
                    ></web-category-list-product-filter>
                </div>

            </aside>
        </div><!--/col filters-->

        <div class="col-md-9 px-lg-3 px-xl-5 section-product-list pb-5">
            <div class="form-group d-flex justify-content-end align-items-center">
                <label class="mb-0 mr-2" >Ordenar por:</label>

                <!--Dropdown primary-->
                <div class="dropdown">
                    <button type="button" class="btn btn-md btn-custom btn-tertiary-custom dropdown-toggle px-3"  data-toggle="dropdown" >
                        {{ $orderText }}
                    </button>
                    <div class="dropdown-menu dropdown-tertiary-custom">
                        <a class="dropdown-item" href="{{ UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['order'=>'last']),['page']) }}">
                            Últimos
                        </a>
                        <a class="dropdown-item" href="{{ UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['order'=>'higher_price']),['page']) }}">
                            Mayor precio
                        </a>
                        <a class="dropdown-item" href="{{ UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['order'=>'lower_price']),['page']) }}">
                            Menor precio
                        </a>
                    </div>
                </div><!--/Dropdown primary-->

            </div>

            <h1 class="h1 mb-4">
                {{ $title }}
            </h1>

            @if(count($products) == 0)
                <div class="row">
                    <div class="col-12 ">
                        <div class="alert alert-primary" role="alert">
                            No se encontraron productos.
                        </div>
                    </div>
                </div>
            @endif

            <div class="row container-list-product mx-n2 mx-md-n3" style="margin-bottom: -1rem;"   >

                @foreach($productsResource as $item)

                    <div class="col-6 col-md-6 col-lg-4 col-xl-3 mb-3 px-2 px-md-3">
                        <web-product-card-primary
                            :item-prop='@json($item)'
                            btn-text-prop="Añadir <span class='text-car' >al carrito</span> " >
                        </web-product-card-primary>
                    </div>
                @endforeach

                @if(count($products) > 0)
                    <div class="col-md-12 d-flex justify-content-center mt-4" >
                        {{ $products ->appends(request()->query())-> links() }}
                    </div>
                @endif
            </div>

        </div><!--/col products-->

    </div><!--/row-->
</div><!--/container-fluid-->


@endsection

@section('script')

@endsection
