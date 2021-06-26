@php
    $loadSelect2= true;
    $classTagMain ="no-margin-top";
@endphp

@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

    @include('web.business.partials.list-business',['mainPage'=>true])

    @php
        $categories = config('constant.category.business_categories');
    @endphp

	<section class="my-5">
		 <div class="container">
		 	<div class="row">
		        <div class="col-12 text-center">
		        	<h2 class="h1 text-uppercase mb-5 ">Nuestras categorías</h2>
		        </div><!--/col-->
		    </div><!--/row-->

		    <div class="row row-card-category-main">
		    	@foreach($categories as $category )
		    	<div class="col-3 mb-3 col-card-category-main">
		    		<div class="card {{ "bg-".$category['slug'] }} card-category-main">
					  	<div class="card-body text-center">
                            <a href="{{ route('businesses.categories.slug.index',$category['slug']) }}"  >
                                <img width="130" data-src="{{ asset("images/categories/".$category['slug'].".png" ) }}" class=" pb-3 img-fluid lazy" >
                                <h5 class="card-title mb-0 text-dark force-2-lines">
                                    {{ $category['name'] }}
                                </h5>
                            </a>
					  	</div>
					</div>
		    	</div>
		    	@endforeach

		    </div>

		 </div>
	</section>

    <web-product-sale-section
        class="my-5"
        class-container-product-prop="col-6 col-md-6 col-lg-4" >
    </web-product-sale-section>

    <web-business-recommended-section class="py-5 grey lighten-4" ></web-business-recommended-section>

    <web-review-last-section class="my-5" ></web-review-last-section>



@endsection


@section('script')
    <script src="{{ asset('funciones/funcGoogleMaps.js') }}"></script>
    <script type="text/javascript">

        const businesses = @json($businessesResource);

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
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?language=es&key={{ config('app.api_key_google_maps') }}&libraries=places&callback=initAutocomplete"  ></script>
@endsection
