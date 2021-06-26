@php
    $urlImgPage = $product->getUrlImageResize('picture',600,600,true,true);
@endphp

@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

    <section class="container post-detail mb-n4">
        <div class="row mb-4">
            <div class="col-md-6">

                <web-product-images-detail
                    product-id-prop="{{ $product->id }}" >
                </web-product-images-detail>
            </div><!--/col-->
            <div class="col-md-6">

                <h1 class="h1 mb-4">{{ $product->name }}</h1>

                <div class="mb-3">
                    <span class="h3">
                        S/ {{ $product->final_price }}
                    </span>
                    @if($product->offer_active)
                        <span class="crossed-out-price h3 ml-3">
                            S/ {{ $product->price }}
                        </span>
                    @endif
                </div>

                <web-shopping-cart-button-increase-item
                class="mb-3"
                product-id-prop="{{ $product->id }}"
                :show-input-prop="true"
                :show-product-detail-modal-prop="true"
                ></web-shopping-cart-button-increase-item>

                <div class="ck-editor5 mb-3">
                    {!! $product->short_description !!}
                </div>

                <p class="mb-0">
                    {{ count($product->categories) > 1 ? 'Categorías:' : 'Categoría:' }}
                    @foreach($product->categories as $item)
                         <a href="{{$item->url_page}}" title="Ver más productos de {{ $item->name }}">{{ $item->name }}</a>{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </p>


            </div><!--/col-->
        </div><!--/row-->

        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h1 mb-4">Descripción</h2>
                <div class="ck-editor5">
                    {!! $product->description !!}
                </div>
            </div>
        </div>

        @if(count($product->categories) > 0)
        <web-product-last
            class="mb-4"
            class-container-product-prop="col-6 col-md-6 col-lg-4"
            quantity-prop="3"
            title-prop="Productos recomendados"
            subtitle-prop=""
            :show-btn-all-prop="false"
            :category-id-prop="{{ $product->categories->first()->id }}"
            :different-product-id-prop="{{ $product->id }}"
        ></web-product-last>
        @endif

    </section><!--/container-->

@endsection

@section('script')

@endsection
