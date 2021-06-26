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
                    <a href="{{ route($prefixRouteWeb.'category_type_slug.create',$categoryType->slug) }}" class="{{ config('constant.button.create.class') }}">
                        <i class="{{ config('constant.icon.create.class') }} mr-2"></i>
                        @lang('button.create')
                    </a>
                @endif

                <a 	href="{{ route($prefixRouteWeb.'category_type_slug.index',$categoryType->slug)  }}"
                      class="{{ config('constant.button.list.class') }}">
                    <i class="{{ config('constant.icon.list.class') }} mr-2"></i>
                    @lang('button.category.list')
                </a>


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

                    <input type="hidden" name="category_type_id" value="{{ $categoryType->id }}">


                    <div class="card card-form mb-3">
                        <div class="card-header">
                            <h3 class="card-header-title">
                                Datos de la categoría
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="md-form ">
                                        <input type="text" id="name" name="name" value="{{ old('name',$model-> name) }}" class="form-control {{ ValidateForm::getValidClass($errors,'name') }}" required maxlength="{{ config('constant.attribute.name.max') }}">
                                        <label for="name">Nombre*</label>
                                        {!! ValidateForm::getErrorDiv($errors,'name') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group md-style">
                                        <label >Padre</label>
                                        <select id="parent_id" class="select-2 init  form-control {{ ValidateForm::getValidClass($errors,'parent_id') }}" name="parent_id" style="width: 100%" >
                                            <option value="">Ninguna</option>
                                            @foreach($parentCategories as $item)
                                                <option value="{{ $item-> id }}" @if($item-> id == old('parent_id',$model-> parent_id)) selected @endif >{{ $item-> name }}</option>
                                            @endforeach
                                        </select>
                                        {!! ValidateForm::getErrorDiv($errors,'parent_id') !!}
                                    </div>
                                </div>


                                <div class="col-md-12 mt-3">
                                    <admin-file-input-basic
                                        url-image="{{ $model-> getUrlThumbnail('picture',true,true) }}"
                                        input-name="picture_object" >
                                    </admin-file-input-basic>
                                    {!! ValidateForm::getBasicErrorDiv($errors,'picture') !!}
                                </div>


                            </div><!--/row-->
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
@endsection
