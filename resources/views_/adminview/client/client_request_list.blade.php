@extends('adminlayout.adminmaster')

@section('title', 'Client Request List')

@section('head')

@stop
@section('content')
    <style>

        .btn_center {
            text-align: center;
            margin-top: 10px;
        }

        .update_btn {
            display: none;
        }

        .hidealways {
            display: none;
        }

        .label_checkbox {
            display: inline-block;
        }

        .label_checkbox .cr {
            margin: 0px 5px;
        }

        .newrow {
            background: #1e81cd52 !important;
        }

        .border_none {
            border: none !important;
        }

    </style>
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">

                <section id="menu2">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       Client Request List
                                     <button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();" ><i class="mdi mdi-download"></i> Download Excel</button>
                    </span>
                                {{--<div id="snackbar">New Categories added Successfully</div>--}}
                                {{--<p class="clearfix"></p>--}}
                                {{--<input id='myInput' class="form-control" placeholder="search" onkeyup='searchTable()'--}}
                                {{--type='text'>--}}
                                <section id="user_table" class="table_main_containner">
                                    <table class="table table-bordered dataTable table-striped scroll_table" id="example">
                                        <thead>
                                        <tr>
                                            <th class="width_18">Material</th>
                                            <th class="width_15">Type</th>
                                            <th class="width_15">Qty/Unit</th>
                                            <th class="width_18">Client</th>
                                            <th class="width_18">Request Time</th>
                                            <th class="width_16">Approval Status</th>
                                            <th class="width_10">Option</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($requests)>0)
                                            @foreach($requests as $request)
                                                <tr>
                                                    <td>{{isset($request->material_id)?$request->material->name:'-'}}</td>
                                                    <td>{{isset($request->material_type_id)?$request->material_type->type:'-'}}</td>
                                                    <td>{{$request->qty.'-'}}{{isset($request->unit_id)?$request->unit->unit:'-'}}</td>
                                                    <td>{{$request->client->name}}</td>
                                                    <td>{{ date_format(date_create($request->created_time), "d-M-Y h:i A")}}</td>
                                                    <td>@if($request->is_approved=='0')
                                                            <div class='status pending'>Pending</div>
                                                        @else
                                                            <div class='status approved'>Approved</div>
                                                        @endif
                                                    </td>
                                                    <td>@if($request->is_approved=='0')
                                                            <button type="button" id="{{ $request->id }}"
                                                                    onclick="getApproved(this);"
                                                                    class="btn btn-xs status approved"
                                                                    title="Mark as Approved"><span class="fa fa-check"
                                                                                                   aria-hidden="true"> </span>Approve
                                                            </button>
                                                        @else
                                                            <span class='badge'>N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    <span class="list_no_record">< No Record Available ></span>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </section>
                            </div>


                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <script>
        function getApproved(dis) {
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/client_request/" + id + "/approved";
            swal({
                title: "Are you sure?",
                text: "You want to mark this request as approved...!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((okk) => {
                if (okk) {
                    $.ajax({
                        type: "GET",
                        contentType: "application/json; charset=utf-8",
                        url: editurl,
                        data: '{"data":"' + id + '"}',
                        success: function (data) {
                            swal("Success", "Request has been approved", "success");
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        },
                        error: function (xhr, status, error) {
                            swal("Server Error", "Request has been declined", "error");
                        }
                    });
                }
            });
        }

    </script>

@stop