@php
    $loadSelect2 = true;
@endphp
@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')

    <section class="container">
        <div class="row">

            <div class="col-md-12">

                <h1 class="h1 mb-5">{{ $title }}</h1>

                <web-order-check-out business-id-prop="{{ isset($business) ? $business->id : '' }}" ></web-order-check-out>

            </div><!--/col-->

        </div><!--/row-->
    </section><!--/container-->

@endsection

@section('script')

@endsection
