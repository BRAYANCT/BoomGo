@php
    $loadSelect2= true;
    $classTagMain ="my-0";
@endphp

@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

{{--    {{ Request::url() }}--}}

{{--    {{ UrlHelper::removeUrlParameters(request()->fullUrlWithQuery(['id'=>1]),['page']) }}--}}

{{--    {{ var_dump(parse_url(request()->fullUrlWithQuery(['id'=>1]))) }}--}}

 @include('web.business.partials.list-business')


@endsection

@section('script')

    <script src="{{ asset('funciones/funcGoogleMaps.js') }}"></script>
    <script type="text/javascript">

        const businesses = @json($businessesResource);

        console.log("businesses:",businesses);

        function initAutocomplete() {
            setTimeout(function(){
                // geocoder = new google.maps.Geocoder();
                initMap(-12.046367,-77.042853,13,"map");

                let inputAutoComplete = initInputAutocomplete("search-address",false);
                inputAutoComplete.addListener('place_changed', setInputPosition);

                let changeOptions = false;

                businesses.forEach(function (item, index, array){
                    if(item.address && item.latitude && item.longitude){
                        if(!changeOptions){
                            changeMapOptions(parseFloat(item.latitude),parseFloat(item.longitude),11);
                        }
                        addMarkerBusiness(item);
                    }
                })

            }, 1000);
        }

        // calcularDistancia({lat:'-12.046367',lng:'-77.042853'},{lat:'-12.048339597162434',lng:'-77.04692995770263'});

        // function calcularDistancia(latlng1,latlng2){
        //
        //     var lat = [latlng1.lat, latlng2.lat]
        //     var lng = [latlng1.lng, latlng2.lng]
        //     var R = 6378137;
        //     var dLat = (lat[1]-lat[0]) * Math.PI / 180;
        //     var dLng = (lng[1]-lng[0]) * Math.PI / 180;
        //
        //     var a = Math.pow(Math.sin(dLat/2),2)+
        //         Math.cos(lat[0] * Math.PI / 180 ) * Math.cos(lat[1] * Math.PI / 180 ) *
        //         Math.pow(Math.sin(dLng/2),2);
        //
        //     var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        //     var d = R * c;
        //     //en metros
        //     return Math.round(d);
        // }

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?language=es&key={{ config('app.api_key_google_maps') }}&libraries=places&callback=initAutocomplete"  ></script>
@endsection
