@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/dataTables.checkboxes.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-6">
                <p>
                    <form class="form-horizontal"></form>
                    <button type="button" class="btn btn-primary" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a class="btn btn-primary" href="{{route('discount.create')}}">
                        <i class="fa fa-plus"></i>&nbsp; New Discount
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-file-excel-o"></i>&nbsp; Export Discount  
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('discount.index') }}/export-data">All</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="selectedExport()">Selected</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#primaryModal" data-link="{{route('discount.index')}}/import"
                        onclick="funcModal($(this))" data-backdrop="static" data-keyboard="false">
                        <i class="fa fa-cloud-download"></i>&nbsp; Import Discount
                    </button>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Products Table
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th id="datatables-th-checkbox"></th>
                                        <th class="text-nowrap">Discount :</th>
                                        <th class="text-nowrap">Value :</th>
                                        <th class="text-nowrap">Unique Modifier :</th>
                                        <th class="text-nowrap">Expired Date :</th>
                                        <th class="text-nowrap">Date registered :</th>
                                        <th class="text-nowrap">Status :</th>
                                        <th class="text-nowrap"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="hidden" id="sendExport" method="POST" action="{{ route('discount.index') }}/export-selected">
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.checkboxes.min.js') }}"></script>

<script>
    //DATATABLES
    var dataTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("discount.index")}}/list-data',
        columns: [
            {
                data: '_id',
                name: '_id',
                orderable: false, 
                searchable: false,
                checkboxes: true,
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'value_set',
                name: 'value_set'
            },
            {
                data: 'unique_modifier',
                name: 'unique_modifier'
            },
            {
                data: 'expired_date',
                name: 'expired_date'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'status_set',
                name: 'status_set'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '15%'
            }
        ],
        columnDefs: [{
                responsivePriority: 1,
                targets: 0,
            },
            {
                targets: [6,7],
                className: "text-center"
            },
            {
                responsivePriority: 2,
                targets: 7,
            }
        ],
        "order": [
            [5, 'desc']
        ]
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');

    function discountSetting(elm){
        swal({
            title: "Are you sure want to change status discount?",
            text: "Please make sure discount you want set..",
            buttons: true,
        }).then((confirm) => {
            if(confirm){
                var action = elm.is(":checked");
                var id = elm.attr('data-id');
                $.ajax({
                    url: '{{ route("discount.index")}}/discount-setting',
                    type: 'GET',
                    data:{action:action, id:id},
                    success: function (response) {
                        if(response == 'success'){
                            swal({
                                title: "Discount set successfuly.",
                            });
                            toastr.success('Successful set discount status..', 'An discount has been set.');
                        }else{
                            swal({
                                title: "Process invalid",
                                text: "Please contact technical support.",
                                dangerMode: true,
                            });
                            refresh();
                        }
                    },
                    error: function (e) {
                        swal({
                            title: "Process invalid",
                            text: "Please contact technical support.",
                            dangerMode: true,
                        });
                        refresh();
                    }
                });
            }else{
                //refresh datatables
                refresh();
            }
        });
    }

    function selectedExport(){
        var rows_selected = dataTable.column(0).checkboxes.selected();
        $.each(rows_selected, function(index, rowId){
            // Create a hidden element
            $('#sendExport').append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'id[]')
                    .val(rowId)
            );
        });
        $('#sendExport').trigger('submit');
    }
</script>

@endsection