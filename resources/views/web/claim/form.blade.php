@php
    $loadSelect2= true;
    // $classTagMain ="my-0";
@endphp

@extends('web.layouts.web-template')

@section('title', $title)

@section('description',$description)

@section('content')
    <div class="container">

        <div class="row ">
            <div class="col-12">
                <h1 class="h1 mb-4">{{ $title }}</h1>

                <h2 class="text-center h4"  >
                    "Hoja de Reclamación N° {{ $nextCode }}" - {{ date('d/m/Y') }}
                </h2>

                <h2 class="text-center h4 mb-5"  >
                    BOOM GO S.A.C. - RUC 20001111111 - JR. RIO NRO. 436 DPTO. 101 LIMA - LIMA - SAN LUIS
                </h2>

            </div><!--/col-->
            <div class="col-12">
                <web-claim-create-form></web-claim-create-form>
            </div>
        </div><!--/row-->
    </div><!--/container-->

@endsection


