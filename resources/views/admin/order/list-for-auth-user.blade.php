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
            </div><!--/col-->

            <div class="col-12">
                <admin-order-list-for-auth-user></admin-order-list-for-auth-user>
            </div>

        </div><!--/row-->
    </div><!--/container-->
@endsection


