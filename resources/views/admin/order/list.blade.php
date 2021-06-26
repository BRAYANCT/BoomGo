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

                <div class="card card-cascade card-table narrower mt-5">

                    <!--Card image-->
                    <div class="view gradient-card-header narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                        <h2 class="h5 card-header-title">
                            {{ $title }}
                        </h2>

                    </div><!--/Card image-->

                    <div class="px-2 px-sm-4 mt-1 mb-4">

                        <div class="table-wrapper ">

                            <table id="tabla-listado" class="table table-striped table-hover  table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Fecha Registro</th>
                                    <th>Negocio</th>
                                    <th>Código</th>
                                    <th>Usuario</th>
                                    <th>Cantidad Total</th>
                                    <th>Precio Total</th>
                                    <th>Estado</th>
                                    <th>Pago</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Fecha Registro</th>
                                    <th>Negocio</th>
                                    <th>Código</th>
                                    <th>Usuario</th>
                                    <th>Cantidad Total</th>
                                    <th>Precio Total</th>
                                    <th>Estado</th>
                                    <th>Pago</th>
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
                    }, 800);
                },
                "ajax": {
                    "url": "{{ $urlApiList }}",
                    "type": 'GET',
                    "data": {'is_admin_business':'{{ $isAdminBusiness }}'},
                },
                "columns": [
                    { "data": "display_created_at" },
                    { "data": "business_name" },
                    { "data": "code" },
                    { "data": "user_display_name" },
                    { "data": "quantity_total"},
                    { "data": "total"},
                    { "data": "order_state_badge"},
                    { "data": "payment_method_name"},
                    { "data": "actions" },
                ],
                "responsive":false,
                "scrollX": true,
                "columnDefs": [
                    { "orderable": false, targets: [7] },

                    @if($isAdminBusiness)
                    {
                        "targets": [ 1 ],
                        "visible": false,
                        "searchable": false,
                    },
                    @endif
                ],
                "order": [[ 0, 'desc' ]],
                "language": window.dt_es,
                "pageLength": 10,
                "aLengthMenu": [ 5 ,10, 25, 50, 75, 100 ]
            });

        };


    </script>
@endsection
