
@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

    <section class="container post-detail">
        <div class="row">
            <div class="col-12">
                <h1 class="h1 mb-4">{{ $title }}</h1>
            </div>
        </div><!--/row-->

        <div class="row">
            <div class="col-12">
                <web-shopping-cart-list></web-shopping-cart-list>
            </div>
        </div><!--/row-->
    </section><!--/container-->

@endsection

@section('script')

@endsection
