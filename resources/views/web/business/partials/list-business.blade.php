@php
    $fullUrl = url()->full();

    $mainPage = isset($mainPage) ? $mainPage : false;

    if($mainPage){
        $fullUrl = route('businesses.index');
    }

    $filtersActive = array();

    $orderText = "Recomendados";
    $priceRange = "";

    if(Request::get('order')){
        $order = Request::get('order');
        if($order =="recommended"){
            $orderText = "Recomendados";
        }else if($order =="last"){
            $orderText = "Últimos";
        }
    }

    if(Request::get('address')){
        array_push($filtersActive,Request::get('address'));
    }

    if(Request::get('price_range')){
        $priceRange = Request::get('price_range');
        $symbol = "";
        for ($i=0;$i<$priceRange;$i++){
            $symbol .="$";
        }
        array_push($filtersActive,$symbol);
    }

    if(isset($category)){
        array_push($filtersActive,$category->name);
    }

    if(Request::get('provider_type_id')){
        $providerType = Request::get('provider_type_id');
        array_push($filtersActive,ProviderTypeHelper::getName($providerType));
    }

    if(Request::get('province_id')){
        $provinceId = Request::get('province_id');
        array_push($filtersActive,ProvinceHelper::getName($provinceId));
    }

    if(Request::get('search_text')){
        array_push($filtersActive,Request::get('search_text'));
    }

    if(Request::get('type_view')){
        $typeView = Request::get('type_view');
    }else{
        $typeView = "list";
    }

@endphp

<section class="container-fluid p-0 ">
    <div class="row m-0 mt-sm-4 mt-md-0">

        <div class="col-12 d-block d-md-none mb-3" style="margin-top: 3rem;">
            <div class="row">
                <div class="col-5">
                    <button type="button" class="btn btn-sm btn-tertiary-custom btn-toggle-show-filter m-0">
                        Filtros
                    </button>

                    <button type="button" class="btn btn-sm btn-tertiary-custom btn-toggle-show-filter-fixed m-0">
                        Filtros
                    </button>
                </div>

                <div class="col-7 text-right">
                    <div class="btn-group" >
                        <a href="{{ route('businesses.index',['type_view'=>'list']) }}" class="btn btn-tertiary-custom btn-sm px-3 btn-load-page {{ $typeView == 'list' ? 'disabled' : '' }}">
                            <i class="{{ config('constant.icon.list.class') }}"></i> Lista
                        </a>
                        <a href="{{ route('businesses.index',['type_view'=>'map']) }}" class="btn btn-tertiary-custom btn-sm px-3 btn-load-page {{ $typeView == 'map' ? 'disabled' : '' }} ">
                            <i class="{{ config('constant.icon.map.class') }}"></i> Mapa
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-block d-md-none mb-3" >
            <form method="GET" action="{{ route('businesses.index') }}" >
                <div class="input-group input-icon-custom border">
                    <div class="input-group-prepend" >
                        <span class="input-group-text h-100" >
                            <button type="submit" >
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Buscar restaurantes, barberías ..." name="search_text" required  />
                </div>
            </form>
        </div>

        <div class="col-md-3 tertiary-custom-color filters-business-list-container ">

            <aside class="tertiary-custom-color px-lg-3 px-xl-5 py-5 h-100 filters-business-list">

                @if(count($filtersActive)>0)
                    <h4 class="h5 text-secondary-custom mb-2">
                        {{ count($filtersActive) }} {{ count($filtersActive)==1 ? 'filtro' : 'filtros' }}
                    </h4>
                    <div class="small mb-3 text-white">
                        @foreach($filtersActive as $value)
                            <span>{{ $value }}</span> @if(!$loop->last)-@endif
                        @endforeach
                        <br>
                        <a href="{{ route('businesses.index') }}" class="text-primary-custom">
                            <i class="{{config('constant.icon.delete.class')}}"></i> Borrar todo
                        </a>
                    </div>
                @endif

                <h3 class="h3 text-secondary-custom text-uppercase mb-4">Filtros</h3>

                <div class="mb-4 pr-3 pr-lg-0">
                    <h4 class="h5 text-secondary-custom mb-3">Categorías</h4>
                    <web-category-list-business-filter
                        category-id-prop="{{ isset($category) ? $category->id : ''  }}"
                        class="pl-2"
                    ></web-category-list-business-filter>
                </div>

                <web-business-province-filter class="mb-4 pr-3 pr-lg-0" url-prop="{{$fullUrl}}">
                </web-business-province-filter>

{{--                <div class="mb-4">--}}
{{--                    <h4 class="h5 text-secondary-custom mb-3">Ubicación</h4>--}}
{{--                    <form action="{{ UrlHelper::removeUrlParameters($fullUrl,['page']) }}" method="GET" >--}}

{{--                        @if(Request::get('price_range'))--}}
{{--                            <input type="hidden" value="{{Request::get('price_range')}}" name="price_range">--}}
{{--                        @endif--}}

{{--                        <div class="input-group input-icon-custom mb-3">--}}
{{--                            <div class="input-group-prepend click-action" >--}}
{{--                                    <span class="input-group-text h-100" >--}}
{{--                                        <i class="fas fa-search text-grey"></i>--}}
{{--                                    </span>--}}
{{--                            </div>--}}
{{--                            <input id="search-address" type="text" class="form-control" name="address" placeholder="Escriba la dirección" value="{{Request::get('address')}}"  />--}}
{{--                            <input type="hidden" name="latitude" class="input-latitude" value="{{ Request::get('latitud') }}" >--}}
{{--                            <input type="hidden" name="longitude"  class="input-longitude" value="{{ Request::get('longitude') }}" >--}}
{{--                        </div>--}}

{{--                        <div class="form-check primary-custom mb-2 p-0">--}}
{{--                            <input type="radio" class="form-check-input" id="distance-5" name="distance" value="5" {{ Request::get('distance') == 5 || empty(Request::get('distance')) ? 'checked' : '' }} >--}}
{{--                            <label class="form-check-label text-white" for="distance-5">5 km</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-check primary-custom mb-2 p-0">--}}
{{--                            <input type="radio" class="form-check-input" id="distance-10" name="distance" value="10" {{ Request::get('distance') == 10 ? 'checked' : '' }} >--}}
{{--                            <label class="form-check-label text-white" for="distance-10">10 km</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-check primary-custom mb-2 p-0">--}}
{{--                            <input type="radio" class="form-check-input" id="distance-15" name="distance" value="15" {{ Request::get('distance') == 15 ? 'checked' : '' }}>--}}
{{--                            <label class="form-check-label text-white" for="distance-15">15 km</label>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}

                <div class="mb-4">
                    <h4 class="h5 text-secondary-custom mb-3">Precio</h4>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{--                            <a href="{{ route('businesses.index',['price_range'=>1]) }}" class="btn btn-outline-primary-custom btn-rounded">$</a>--}}
                        <a href="{{ $mainPage ? route('businesses.index',['price_range'=>1]) : UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['price_range'=>1]),['page']) }}"
                           class="btn btn-outline-primary-custom btn-rounded btn-sm {{$priceRange == 1 ? 'active ' : ''}}">
                            $
                        </a>
                        <a href="{{ $mainPage ? route('businesses.index',['price_range'=>2]) : UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['price_range'=>2]),['page']) }}"
                           class="btn btn-outline-primary-custom btn-rounded btn-sm {{$priceRange == 2 ? 'active ' : ''}}">
                            $$
                        </a>
                        <a href="{{ $mainPage ? route('businesses.index',['price_range'=>3]) : UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['price_range'=>3]),['page']) }}"
                           class="btn btn-outline-primary-custom btn-rounded btn-sm {{$priceRange == 3 ? 'active ' : ''}}">
                            $$$
                        </a>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="h5 text-secondary-custom mb-3">Tipo de proveedor</h4>
                    <web-provider-type-list-business-filter url-prop="{{ $fullUrl }}" class="pl-2"
                    ></web-provider-type-list-business-filter>
                </div>

            </aside>
        </div>

        <div class="col-md-6 px-lg-3 px-xl-5 section-business-list {{ $typeView == 'list' ? 'active-mobile' : '' }}">
            <div class="form-group d-flex justify-content-end align-items-center">
                <label class="mb-0 mr-2" >Ordenar por:</label>

                <!--Dropdown primary-->
                <div class="dropdown">
                    <button type="button" class="btn btn-md btn-tertiary-custom btn-custom dropdown-toggle px-3"  data-toggle="dropdown" >
                        {{ $orderText }}
                    </button>
                    <div class="dropdown-menu dropdown-tertiary-custom">
                        <a class="dropdown-item" href="{{ $mainPage ? route('businesses.index',['order'=>'recommended']) : UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['order'=>'recommended']),['page']) }}">
                            Recomendados
                        </a>
                        <a class="dropdown-item" href="{{ $mainPage ? route('businesses.index',['order'=>'last']) : UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['order'=>'last']),['page']) }}">
                            Últimos
                        </a>
                    </div>
                </div><!--/Dropdown primary-->

{{--                <select id="order" class="select-2 init  form-control tertiary-custom select2-radius" name="order" style="min-width: 300px;"  >--}}
{{--                    <option value="">Recomendados</option>--}}
{{--                </select>--}}
            </div>
            <h1 class="h1 mb-3">{{ isset($titleFilter) ? $titleFilter : 'Nuevos Negocios' }}</h1>

            <div class="row">
                @if(count($businesses) == 0)
                    <div class="col-12 ">
                        <div class="alert alert-primary" role="alert">
                            No se encontraron negocios.
                        </div>
                    </div>
                @endif


                @foreach($businesses as $item)
                    <div class="col-12 ">
                        <!-- Card -->
                        <div class="card card-list-business">

                            <!-- Card image -->
                            <div class="view overlay">
                                <img class="card-img-top" src="{{ $item->getUrlImageMedium('logo',true,true) }}" alt="{{$item->name}}">
                                <a href="{{ $item->url_page }}" title="Ir a la página del negocio">
                                    <div class="mask rgba-white-slight"></div>
                                </a>
                            </div>

                            <!-- Card content -->
                            <div class="card-body">
                                <h4 class="card-title ">
                                    <a href="{{ $item->url_page }}" class="font-weight-bold h5" title="Ir a la página del negocio" >
                                        {{ $item->name }}
                                    </a>
                                </h4>
                                <web-review-start-average class="mb-1"
                                    score-average-prop="{{ $item->score_average }}"
                                    total-reviews-prop="{{ $item->total_reviews }}"
                                >
                                </web-review-start-average>
                                <p class="mb-2">
                                    {{ $item->priceRange ? $item->priceRange ->symbol : '' }} - {{ $item->address }}
                                </p>
                                <p class="card-text">
                                    {{ $item->description }}
                                </p>
                                @if(count($item->providerTypes)>0)
                                    <p class="provider-types">
                                        @foreach($item->providerTypes as $providerType)
                                            {{ $loop->index > 0 && $loop->last ? ',' : ''  }}  {{ $providerType->name }}
                                        @endforeach
                                    </p>
                                @endif
                                <a href="{{ $item->url_page }}" class="btn btn-primary-custom btn-sm btn-custom m-0">
                                    <i class="{{config('constant.icon.business.class')}}"></i> Ver negocio
                                </a>
                            </div><!--/ Card-body -->

                        </div><!--/ Card -->
                        <hr class="my-4">
                    </div><!--/col-->
                @endforeach

{{--                @if($mainPage)--}}
{{--                    <div class="col-12 text-center mb-3">--}}
{{--                        <a href="{{ route('businesses.index') }}" class="btn btn-secondary-custom btn-custom">--}}
{{--                            Ver todos los negocios--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                @if(count($businesses) > 0 && !$mainPage )--}}
                @if(count($businesses) > 0 )
                    <div class="col-md-12 d-flex justify-content-center" >
                        {{ $businesses ->appends(request()->query())-> links() }}
                    </div>
                @endif

            </div><!--/row-->

        </div><!--/col-->

        <div class="col-md-3 p-0 section-business-map {{ $typeView == "map" ? 'active-mobile' : '' }} " >
            <div id="map" style="height: 100%!important;"></div>
        </div>
    </div>
</section>
