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
                <a 	href="{{ route($prefixRouteWeb.'create') }}"
                      class="{{ config('constant.button.create.class') }}" >
                    <i class="{{ config('constant.icon.create.class') }} mr-2"></i>
                    @lang('button.create')
                </a>

                <div class="card card-cascade card-table narrower mt-5">

                    <!--Card image-->
                    <div class="view gradient-card-header narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                        <h2 class="h5 card-header-title">
                            {{ $title }}
                        </h2>

                        <div>

                            <a 	id="borrar-array-ids"
                                  data-url="{{ route($prefixRouteApi.'destroy_by_ids') }}"
                                  class="{{ config('constant.button.destroy_by_ids.class') }} px-2"
                                  data-toggle="tooltip"
                                  title="@lang('button.destroy_by_ids_title')" >

                                <i class="{{ config('constant.icon.destroy.class') }} {{ config('constant.icon.destroy.color') }} mt-0">
                                </i>
                            </a>
                        </div>
                    </div><!--/Card image-->

                    <div class="px-2 px-sm-4 mt-1 mb-4">

                        <div class="table-wrapper ">

                            <table id="tabla-listado" class="table table-striped table-hover  table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checkbox-table " id="checkbox-head">
                                            <label class="custom-control-label" for="checkbox-head"></label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Fecha registro</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checkbox-table " id="checkbox-footer">
                                            <label class="custom-control-label" for="checkbox-footer"></label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Fecha registro</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>

                        </div> <!--// table-wrapper -->
                    </div>
                </div><!--// card -->


            </div><!--/col-->
        </div><!--/row-->
    </div><!--/container-->
@endsection

@section('script')
    <script type="text/javascript">

        let tablaListado = null;

        let inicializar = function (){

            tablaListado = $('#tabla-listado').DataTable( {
                "initComplete" : function(settings, json) {
                    $('[data-toggle="tooltip"]').tooltip();
                    dtFunc.inicializarCheckBox();
                    setTimeout( function(){
                        dtFunc.widthAdjust();
                    }, 800)
                },
                "ajax":"{{ route($prefixRouteApi.'list_table.index')}}",
                "columns": [
                    { "data": "checkbox" }, // envia el id para luego armar el check
                    { "data": "id" },
                    { "data": "names" },
                    { "data": "email" },
                    { "data": "username" },
                    { "data": "display_date_created_at" ,"type": "date-eu"},
                    { "data": "actions" },
                ],
                "responsive":false,
                "scrollX": true,
                "columnDefs": [
                    { "orderable": false, targets: [0,6] },
                ],
                "order": [[ 5, 'desc' ]],
                "language": window.dt_es,
                "pageLength": 10,
                "aLengthMenu": [ 5 ,10, 25, 50, 75, 100 ]
            });

        };


    </script>
@endsection
