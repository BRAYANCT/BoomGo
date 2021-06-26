@php
    $classTagBody = "no-menu-curve";
    $classTagMain = "mt-0";

    $urlImgPage = $business->getUrlImageResize('logo',600,600,true,true);
    $isPageBusiness = true;
@endphp

@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

    <section class="container-fluid px-0" >
        <web-business-images-slider-detail
            business-id-prop="{{ $business->id }}"
        >
        </web-business-images-slider-detail>
    </section>

    <section class="container mt-3">

        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="h1">{{ $business->name }}</h1>

                <web-review-start-average
                    class="mb-2"
                    score-average-prop="{{ $business->score_average }}"
                    total-reviews-prop="{{ $business->total_reviews }}"
                    text-total-reviews-prop="comentarios"
                    >
                </web-review-start-average>

                <div class="row mb-4" style="margin-bottom: -1.5rem;">
                    <div class="col-12 d-flex ">
                        <web-review-form-modal
                            btn-class-prop="btn btn-custom btn-secondary-custom m-0 px-3 px-sm-4"
                            model-id-prop="{{ $business->id }}"
                            btn-text-prop="Dejar comentario">
                        </web-review-form-modal>

                        <button class="btn btn-custom  btn-outline-grey m-0 ml-2 px-3 px-sm-4" data-toggle="modal" data-target="#modal-share-page">
                            <i class="{{config('constant.icon.share.class')}}"></i> Compartir
                        </button>
                    </div><!--/col-->
                </div><!--row-->

                <div class="row mb-4">
                    <div class="col-md-8">
                        <form method="GET" action="{{ route('products.businesses.by_slug',$business->slug) }}" >
                            <div class="input-group input-icon-custom border">
                                <div class="input-group-prepend" >
                                    <span class="input-group-text h-100" >
                                        <button type="submit" >
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Buscar productos ..." name="search_text" required  />
                            </div>
                        </form>
                    </div>
                </div>
            </div><!--/col-->

            <div class="col-md-4">
                <div class="border border-light rounded p-4" >
                    <div style="margin-bottom: -15px;">
                        @if($business->phone)
                            <p  class="text-dark" >
                                <a href="tel:{{ $business->phone }}" class="text-dark" >
                                    <i class="{{config('constant.icon.phone.class')}} mr-1"></i>
                                    {{ $business->phone }}
                                </a>
                            </p>
                        @endif

                        @if($business->whatsapp)
                            <p  class="text-dark" >
                                <a href="https://api.whatsapp.com/send?phone=51{{ $business->whatsapp }}" target="_blank" class="text-blue text-decoration-underline" >
                                    <i class="{{config('constant.icon.whatsapp.class')}} mr-1" style="font-size:1.2rem"></i>
                                    Mandar mensaje {{ $business->whatsapp }}
                                </a>
                            </p>
                        @endif

                        @if($business->email)
                            <p>
                                <a href="mailto:{{ $business->email }}" class="text-dark">
                                    <i class="{{config('constant.icon.email.class')}} mr-1"></i>
                                    {{ $business->email }}
                                </a>
                            </p>
                        @endif

                        @if($business->address)
                            <p>
                                <a data-toggle="modal" data-target="#address-map" >
                                    <i class="{{config('constant.icon.address.class')}} mr-1"></i>
                                    Ver mapa
                                </a>
                            </p>
                        @endif

                            @if($business->email)
                                <p>
                                    <a href="{{ $business->catalog_link }}" target="_blank" class="text-dark">
                                        <i class="{{config('constant.icon.url.class')}} mr-1"></i>
                                        Link del catálogo
                                    </a>
                                </p>
                            @endif
                    </div>
                </div>
            </div><!--col-->
        </div><!--/row-->


        <web-category-products-mega-menu
            business-id-prop="{{ $business->id }}"
            business-slug-prop="{{ $business->slug }}"
            btn-class-prop="btn-tertiary-custom btn-custom btn-lg m-0"
            class="mb-4">
        </web-category-products-mega-menu>

        <web-category-list-card-product
            class="mb-4"
            class-container-card-prop="col-3 col-card-category"
            business-id-prop="{{ $business->id }}"
            business-slug-prop="{{ $business->slug }}" >
        </web-category-list-card-product>

        <web-product-best-offers
            class="mb-4"
            class-container-product-prop="col-6 col-md-6 col-lg-4"
            quantity-prop="6"
            business-id-prop="{{ $business->id }}"
            business-slug-prop="{{ $business->slug }}"
        ></web-product-best-offers>

        <web-product-last
            class="mb-4"
            class-container-product-prop="col-6 col-md-6 col-lg-4"
            quantity-prop="6"
            business-id-prop="{{ $business->id }}"
            business-slug-prop="{{ $business->slug }}"
            offer-prop="0"
        ></web-product-last>

        <div class="row">
            @if(!empty($business->address))
                <div class="col-12 mb-4">
                    <h3 class="h4 mb-3">
                        Dirección
                    </h3>
                    {{--                            <div id="map1" class="mb-2" style="height: 200px" >--}}
                    {{--                            </div>--}}
                    @php
                      $priceRangeSymbol = $business->priceRange ? $business->priceRange->symbol : ''
                    @endphp
                    <p class="mb-0 font-weight-bold">
                        {{ $priceRangeSymbol }}{{ $priceRangeSymbol && $business->address ? ' - ' : '' }}{{ $business->address }}
                    </p>
                </div>
            @endif

            <div class="col-12 mb-4">
                <h3 class="h4 mb-3">
                    Acerca de
                </h3>
                <div class="d-flex align-items-center mb-3">
                    <img width="50" height="50" class="rounded-circle lazy mr-2" data-src="{{ empty($business->user->getUrlThumbnail('profile_picture',true,true)) ? $business->user->profile_picture_default_url : $business->user->getUrlThumbnail('profile_picture',true,true) }}">
                    <span class="font-weight-bold">{{ $business->user->display_name }}</span>
                </div>
                <p class="mb-0">
                    {{ $business->description }}
                </p>
            </div>

            <div class="col-12 mb-4">
                <web-business-last-reviews
                    business-id-prop="{{ $business->id }}"
                    class-container-review-prop="col-12"
                ></web-business-last-reviews>
            </div>
        </div><!--/row-->

        <div class="modal fade" id="address-map"  >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dirección</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <i class="{{ config('constant.icon.address.class') }} mr-2"></i>
                            <strong>{{ $business->address }}</strong>
                        </p>
                        <div id="map"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div><!--/modal-footer-->
                </div><!--/modal-content-->
            </div><!--/modal-dialog-->
        </div><!--/modal-->

        <div class="modal fade" id="modal-share-page"  >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Comparte esta página</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h3 class="h1 mb-5 ">
                            ¿Te gusta ésta página? <br> Compártela con tus amigos!
                        </h3>
                        <div class="addthis_inline_share_toolbox"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div><!--/modal-footer-->
                </div><!--/modal-content-->
            </div><!--/modal-dialog-->
        </div><!--/modal-->

    </section><!--/container-->

@endsection

@section('script')
    <script src="{{ asset('funciones/funcGoogleMaps.js') }}"></script>
    <script type="text/javascript">

        let address = "{{ $business->address }}";
        let latitude = parseFloat("{{ $business->latitude }}");
        let longitude = parseFloat("{{ $business->longitude }}");

        function initAutocomplete() {
            setTimeout(function(){
                if(address){
                    initMap(latitude,longitude,13,"map");
                    addMarker(address,latitude,longitude,"");

                    // let map = initMap(latitude,longitude,13,"map1");
                    // addMarker(address,latitude,longitude,"",{draggable:false},map);
                }
            }, 500);
        }

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?language=es&key={{ config('app.api_key_google_maps') }}&libraries=places&callback=initAutocomplete"  ></script>

    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f9aea2b81fb1b91"></script>

@endsection
