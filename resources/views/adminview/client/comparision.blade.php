@extends('adminlayout.adminmaster')

@section('title', 'Comparision List')

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
                       Material Comparision List
                                    <button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();"><i
                                                class="mdi mdi-download"></i> Download Excel</button>
                    </span>
                                {{--<div id="snackbar">New Categories added Successfully</div>--}}
                                {{--<p class="clearfix"></p>--}}
                                {{--<input id='myInput' class="form-control" placeholder="search" onkeyup='searchTable()'--}}
                                {{--type='text'>--}}
                                <section id="user_table" class="table_main_containner">
                                    <table class="table table-bordered dataTable table-striped scroll_table"
                                           id="example">
                                        <thead>
                                        <tr>
                                            <th class="width_15">Loaded Voucher No</th>
                                            <th class="width_15">Unloaded Voucher No</th>
                                            {{--<th class="width_15">Material</th>--}}
                                            <th class="width_12">Vehicle</th>
                                            <th class="width_10">Loaded Type</th>
                                            <th class="width_10">UnLoaded Type</th>
                                            <th class="width_13">Load Qty/Unit</th>
                                            <th class="width_13">Unload Qty/Unit</th>
                                            <th class="width_10">Difference</th>
                                            {{--<th class="width_15">Estimate Delivery Time</th>--}}
                                            <th class="width_12">Unloaded Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($requests)>0)
                                            @foreach($requests as $ad)
                                                @php
                                                    $diff = $ad->load_qty-$ad->unload_qty;
                                                @endphp
                                                @if($diff != 0 || $ad->loaded_type != $ad->unloaded_type)
                                                    <tr>
                                                        <td>{{isset($ad->loaded_challan)?$ad->loaded_challan:'N/A'}}</td>
                                                        <td>{{isset($ad->unloaded_challan)?$ad->unloaded_challan:'N/A'}}</td>
                                                        <td>{{$ad->vehicle_no}}</td>
                                                        <td>{{$ad->loaded_type}}</td>
                                                        <td>{{$ad->unloaded_type}}</td>
                                                        {{--<td>{{$ad->m_name}}</td>--}}
                                                        <td>{{$ad->load_qty > 0 ? $ad->load_qty.'-' .$ad->unit:'-'}}</td>
                                                        <td>{{$ad->unload_qty.'-'}}{{$ad->unit}}</td>
                                                        <td>
                                                            @if($ad->load_qty > 0)
                                                                <div class="status rejected">{{$ad->load_qty-$ad->unload_qty.'-'}}{{$ad->unit}}</div>
                                                            @else
                                                                {{'-'}}
                                                            @endif
                                                        </td>
                                                        {{--<td>{{ date_format(date_create($ad->estimate_deliver_time), "d-M-Y h:i A")}}</td>--}}
                                                        <td>{{ date_format(date_create($ad->unloaded_time), "d-M-Y h:i A")}}</td>
                                                    </tr>
                                                @endif
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