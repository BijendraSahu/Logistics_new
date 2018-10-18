@extends('adminlayout.adminmaster')

@section('title', 'Petrol Request List')

@section('head')
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
@stop
@section('content')
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">

                <section id="menu2">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       Petrol Requests List
                                    <button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();"><i
                                                class="mdi mdi-download"></i> Download Excel</button>
                    </span>
                                <section id="user_table">
                                    <table class="table table-bordered dataTable table-striped" id="example">
                                        <thead>
                                        <tr>
                                            <th class="width_13">Vehicle No</th>
                                            <th class="width_10">Qty/Unit</th>
                                            <th class="width_20">Staff</th>
                                            <th class="width_20">Request Time</th>
                                            <th class="width_13">Filled Status</th>
                                            <th class="width_20">Filled By</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($petrols)>0)
                                            @foreach($petrols as $ad)
                                                <tr>
                                                    <td>{{$ad->vehicle_no}}</td>
                                                    <td>{{$ad->qty.'-'}}{{$ad->unit}}</td>
                                                    <td>{{isset($ad->staff)?$ad->staff:'-'}}</td>
                                                    <td>{{ date_format(date_create($ad->created_time), "d-M-Y h:i A")}}</td>
                                                    {{--<td>@if($ad->is_active == '1')--}}
                                                    {{--<div class='status approved'>Active</div>--}}
                                                    {{--@else--}}
                                                    {{--<div class='status rejected'>Inactive</div>--}}
                                                    {{--@endif--}}
                                                    {{--</td>--}}
                                                    <td>@if($ad->is_done == '1')
                                                            <div class='status approved'>Filled</div>
                                                        @else
                                                            <div class='status rejected'>Pending</div>
                                                        @endif
                                                    </td>
                                                    <td>{{isset($ad->supervisor)?$ad->supervisor:'-'}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">
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
        function searchTable() {
            var input, filter, found, table, tr, td, i, j;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                    found = false;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>

@stop