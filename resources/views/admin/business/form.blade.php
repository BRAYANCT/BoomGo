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
                    @lang('button.business.list')
                </a>
            </div><!--/col-->
            <div class="col-12">

                <admin-business-form id-prop="{{$model-> id}}" ></admin-business-form>

            </div><!--/col-->
        </div><!--/row-->
    </div><!--/container-->
@endsection

@section('script')
    <script type="text/javascript">
    </script>

    <script src="{{ asset('funciones/funcGoogleMaps.js') }}"></script>
    <script type="text/javascript">
        function initAutocomplete() {
            setTimeout(function(){
                geocoder = new google.maps.Geocoder();
                initMap();

                //agregar el marcador cuando tiene direccion
                @if($model-> id)
                let address = '{{ $model->address }}';
                let lat = parseFloat('{{ $model->latitude }}');
                let lng = parseFloat('{{ $model->longitude }}');

                if(!fg.isEmpty(address) && !fg.isEmpty(lat) && !fg.isEmpty(lng) ){
                    let marker = addMarker(address,lat,lng,'',{'draggable':true});
                    addDragMarker(marker);
                    changeMapOptions(lat,lng,17);
                }

                @endif

                let inputAutoComplete = initInputAutocomplete();
                inputAutoComplete.addListener('place_changed', addAddress);
            }, 3000);
        }

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?language=es&key={{ config('app.api_key_google_maps') }}&libraries=places&callback=initAutocomplete"  ></script>
@endsection
