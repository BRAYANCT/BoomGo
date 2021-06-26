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


                <admin-business-form id-prop="{{$model-> id}}" ></admin-business-form>


                <form class="form-css-validate my-3 form-btn-loader" method='POST'  enctype="multipart/form-data"
                      @if(empty($model-> id))
                      action="{{ route($prefixRouteWeb.'store') }}"
                      @else
                      action="{{ route($prefixRouteWeb.'update',[$model]) }}"
                    @endif
                >
                    {{ csrf_field() }}

                    @if(!empty($model-> id))
                        @method('PUT')
                    @endif


                    <div class="card card-form mb-3">
                        <div class="card-header">
                            <h3 class="card-header-title">
                                Datos del negocio
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                @if(!empty($model->user))
                                    <div class="col-md-6">
                                        <div class="md-form has-helper-text">
                                            <input type="text" id="username" class="form-control" value="{{ $model-> user->username }}" disabled >
                                            <label for="username">Nombre de usuario</label>
                                        </div>
                                        @component('components.form.helper')
                                            <a href="{{route('admin.users.edit',$model->user)}}">
                                                <i class="{{config('constant.icon.user.class')}} mr-2"></i>Editar el usuario
                                            </a>
                                        @endcomponent
                                    </div>
                                @endif

                                @if(empty($model-> id))
                                    <div class="col-12 mb-3">
                                        <div class="form-group md-style">
                                            <label >Usuario*</label>
                                            <select id="user_id" class="select-2 init  form-control {{ ValidateForm::getValidClass($errors,'user_id') }}" name="user_id" style="width: 100%" >
                                                <option value="">Seleccione</option>
                                                @foreach($users as $item)
                                                    <option value="{{ $item-> id }}" @if($item-> id == old('user_id',$model-> user_id)) selected @endif >{{ $item-> full_name }}</option>
                                                @endforeach
                                            </select>
                                            {!! ValidateForm::getErrorDiv($errors,'user_id') !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="md-form {{ !empty($model-> id) ? 'has-helper-text' : ''}}">
                                        <input type="text" id="name" name="name" value="{{ old('name',$model->name) }}" class="form-control {{ ValidateForm::getValidClass($errors,'name') }}" required maxlength="{{ config('constant.attribute.company_name.max') }}">
                                        <label for="name">Nombre*</label>
                                        {!! ValidateForm::getErrorDiv($errors,'name') !!}
                                        @if(!empty($model-> id))
                                            @component('components.form.helper')
                                                <a href="{{ $model->url_page }}">
                                                    <i class="{{config('constant.icon.business.class')}} mr-2"></i>Ver página del negocio
                                                </a>
                                            @endcomponent
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="md-form ">
                                        <input type="email" id="email" name="email" value="{{ old('email',$model-> email) }}" class="form-control {{ ValidateForm::getValidClass($errors,'email') }}" required maxlength="{{ config('constant.attribute.email.max') }}">
                                        <label for="email">Email*</label>
                                        {!! ValidateForm::getErrorDiv($errors,'email') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="md-form ">
                                        <input type="text" id="phone" name="phone" value="{{ old('phone',$model->phone) }}" class="form-control {{ ValidateForm::getValidClass($errors,'phone') }}" required maxlength="{{ config('constant.attribute.phone.max') }}">
                                        <label for="phone">Teléfono*</label>
                                        {!! ValidateForm::getErrorDiv($errors,'phone') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group md-style">
                                        <label >Categoría*</label>
                                        <select id="category_id" class="select-2 init  form-control {{ ValidateForm::getValidClass($errors,'category_id') }}" name="category_id" style="width: 100%" >
                                            <option value="">Seleccione</option>

                                            @foreach($categories as $item)

                                                @if(count($item->childs) > 0)
                                                    <optgroup label="{{ $item-> name }}">
                                                        @foreach($item->childs as $itemChild)
                                                            <option value="{{ $itemChild-> id }}" @if($itemChild-> id == old('category_id',$model-> category_id)) selected @endif >
                                                                {{ $itemChild-> name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @else
                                                    <option value="{{ $item-> id }}" @if($item-> id == old('category_id',$model-> category_id)) selected @endif >
                                                        {{ $item-> name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        {!! ValidateForm::getErrorDiv($errors,'category_id') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group md-style">
                                        <label >Rango de precios</label>
                                        <select id="price_range_id" class="select-2 init  form-control {{ ValidateForm::getValidClass($errors,'price_range_id') }}" name="price_range_id" style="width: 100%" >
                                            <option value="">Sin especificar</option>
                                            @foreach($priceRanges as $item)
                                                <option value="{{ $item-> id }}" @if($item-> id == old('price_range_id',$model-> price_range_id)) selected @endif >
                                                    {{ $item-> name }} - {{ $item-> simbol }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {!! ValidateForm::getErrorDiv($errors,'price_range_id') !!}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="md-form ">
                                        <textarea id="description"  name="description" class="md-textarea form-control {{ ValidateForm::getValidClass($errors,'description') }}" rows="5" >{{ old('description',$model-> description) }}</textarea>
                                        <label for="description">Descripción</label>
                                        {!! ValidateForm::getErrorDiv($errors,'description') !!}
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <admin-file-input-basic
                                        url-image="{{ $model-> getUrlThumbnail('logo',true,true) }}"
                                        input-label="Logo de empresa:"
                                        input-name="logo_object"
                                        helper="@lang('helper.business.logo_dimensions')"
                                    >
                                    </admin-file-input-basic>
                                    {!! ValidateForm::getBasicErrorDiv($errors,'logo_object') !!}
                                </div>

                                @foreach($providerTypes as $item)
                                    <div class="col-md-3 mt-3">
                                        <div class="form-group">
                                            @php
                                                $providerTypesId = old('provider_types_id');
                                                if($providerTypesId){
                                                    $checked = in_array($item->id,$providerTypesId);
                                                }else{
                                                    $checked = $model-> haveProviderType($item->id);
                                                }
                                            @endphp
                                            <label >{{ $item->question_registration }}</label>
                                            <input type="hidden" value="" name="provider_types_id[]">
                                            <div class="switch">
                                                <label>
                                                    No
                                                    <input type="checkbox" name="provider_types_id[]"  value="{{ $item->id }}"  {{ $checked  ? 'checked' : '' }} >
                                                    <span class="lever"></span>
                                                    Sí
                                                </label>
                                            </div>
                                            {!! ValidateForm::getBasicErrorDiv($errors,'provider_types_id.'.$loop->index) !!}
                                        </div>
                                    </div><!--/col-->
                                @endforeach

                            </div><!--/row-->
                        </div><!--/card-body-->
                    </div><!--/card-->

                    <div class="card card-form mb-3">

                        <div class="card-header">
                            <h3 class="card-header-title">
                                Dirección
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row" >

                                <div class="col-md-12 mb-2" >
                                    <input id="latitude" type="hidden" name="latitude" value="{{ $model-> latitude }}" >
                                    <input id="longitude" type="hidden" name="longitude" value="{{ $model-> longitude }}" >
                                    <input id="address-map" class="address-map enter-prevent" type="text" name="address" placeholder="Buscar dirección" value="{{ $model-> address }}">
                                    <div id="map" ></div>
                                </div>

                            </div><!--/ row  -->
                        </div><!--/ card body  -->
                    </div><!--/ card  -->

                    <div class="card card-form mb-3" >
                        <div class="card-header">
                            <h3 class="card-header-title">
                                Galería de imágenes
                            </h3>
                        </div>
                        <div class="card-body" >
                            {{--                            <admin-file-input-multiple  >--}}
                            {{--                            </admin-file-input-multiple>--}}

                        </div><!--/card-body-->
                    </div><!--/card-->

                    @if(empty($model-> id))
                        <button class="{{ config('constant.button.store.class') }}" type="submit"  >
                            <i class="{{ config('constant.icon.store.class') }} mr-1"></i>
                            @lang('button.store')
                        </button>
                    @else
                        <button class="{{ config('constant.button.update.class') }}" type="submit"  >
                            <i class="{{ config('constant.icon.update.class') }} mr-1"></i>
                            @lang('button.update')
                        </button>

                        <button id="btn-destroy"
                                class="{{ config('constant.button.destroy.class') }}"
                                type="button">
                            <i class="{{ config('constant.icon.destroy.class') }} mr-1"></i>
                            @lang('button.destroy')
                        </button>
                    @endif
                </form>

                @if(!empty($model-> id))
                    <form id="form-destroy" action="{{ route($prefixRouteWeb.'destroy',[$model]) }}" method="POST" >
                        @csrf
                        @method('DELETE')
                    </form>
                @endif

            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
    </script>

    <script src="{{ asset('funciones/funcGoogleMaps.js') }}"></script>
    <script type="text/javascript">
        function initAutocomplete2() {
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
