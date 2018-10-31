@extends('adminlayout.adminmaster')

@section('title', 'Unloaded Item List')

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
                       UnLoaded Item List
                                    <button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();"><i
                                    class="mdi mdi-download"></i> Download Excel</button>
                    </span>
                                {{--<div id="snackbar">New Categories added Successfully</div>--}}
                                {{--<p class="clearfix"></p>--}}
                                {{--<input id='myInput' class="form-control" placeholder="search" onkeyup='searchTable()'--}}
                                {{--type='text'>--}}
                                <section id="user_table" class="table_main_containner">
                                    <form action="{{url('unloaded_items')}}" method="post"
                                          enctype="multipart/form-data">
                                        <div class="col-sm-12">
                                            <div class="col-sm-4">
                                                <label for="">Start End</label>
                                                <input type="text" placeholder="Start Date"
                                                       data-format="dd/MM/yyyy hh:mm:ss" autocomplete="off"
                                                       class="form-control dtp"
                                                       name="start_date"/>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="">End Date</label>
                                                <input type="text" placeholder="End Date" class="form-control dtp"
                                                       autocomplete="off" name="end_date"/>
                                            </div>
                                            <br>
                                            <div class="col-sm-4">
                                                <span></span>
                                                <button class="btn btn-primary">Search</button>
                                                <a href="{{url('unloaded_items')}}" class="btn btn-success">Refresh</a>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ url('unloaded_items_delete') }}" method="post" id="loaded_frm"
                                          onSubmit="if(!confirm('Are you sure you want to delete selected record?')){return false;}">
                  <div class="btn-div">                     <input type="submit" name="submit" class="btn btn-danger btn_post btn-cancel"
                                               value="Delete"/></div>
                                        <div class="table-scroll style-scroll">
                                        <table class="table table-bordered dataTable table-striped scroll_table"
                                               id="example">
                                            <thead>
                                            <tr>
                                                <th class="hidden">Id</th>
                                                <th class="width_10">Select Delete</th>
                                                <th class="width_18">UnLoaded Time</th>
                                                <th class="width_15">Loaded Voucher No</th>
                                                <th class="width_15">Unloaded Voucher No</th>
                                                <th class="width_15">Vehicle</th>
                                                <th class="width_20">Material</th>
                                                <th class="width_15">Type</th>
                                                <th class="width_17">Load Qty/Unit</th>
                                                <th class="width_17">Unload Qty/Unit</th>
                                                <th class="width_15">Location</th>
                                                <th class="width_15">Crusher</th>
                                                <th class="width_15">ETP No </th>
                                                <th class="width_15">Q/M</th>
                                                {{--<th class="width_18">Loaded Available</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($unloaded_items)>0)
                                                @foreach($unloaded_items as $ad)
                                                    @php
                                                        $loaded = \App\ManagerRequest::where(['challan_no'=>$ad->load_challan_no])->first();
                                                         $load_unit = \App\Unit::find($ad->load_unit);
                                                    @endphp
                                                    <tr>
                                                        <td class="hidden">{{$ad->id}}</td>
                                                        <td>
                                                            <input type="checkbox" value="{{$ad->id}}"
                                                                   name="unloaded_id[]"/>
                                                            <button type="button" onclick="edit_unloaded(this)"
                                                                    id="{{$ad->id}}"
                                                                    class="btn btn-primary btn-edit">Edit
                                                            </button>
                                                        </td>
                                                        {{--                                                        <td>{{isset($ad->loaded_challan)?$ad->loaded_challan:'N/A'}}</td>--}}
                                                        <td>{{ date_format(date_create($ad->unloaded_time), "d-M-Y h:i A")}}</td>
                                                        <td>{{isset($ad->load_challan_no)?$ad->load_challan_no:'N/A'}}</td>
                                                        <td>{{isset($ad->challan_no)?$ad->challan_no:'N/A'}}</td>
                                                        <td>{{isset($ad->vehicle_no)?$ad->vehicle_no:"-"}}</td>
                                                        {{--                                                        <td>{{isset($ad->vehicle_no)?$ad->vehicle_no:'-'}}</td>--}}
                                                        <td>{{isset($ad->material_id)?$ad->material->name:'-'}}</td>
                                                        {{--                                                        <td>{{isset($ad->material_name)?$ad->material_name:'-'}}</td>--}}
                                                        <td>{{isset($ad->material_type_id)?$ad->material_type->type:'-'}}</td>
                                                        {{--                                                        <td>{{isset($ad->material_type)?$ad->material_type:'-'}}</td>--}}
                                                        <td>
                                                            @if(isset($ad))
                                                                {{$ad->load_qty.'-'}}{{isset($load_unit)?$load_unit->unit:'-'}}
                                                            @else
                                                                {{"-"}}
                                                            @endif
                                                        </td>
                                                        <td>{{$ad->unload_qty.'-'}}{{isset($ad->unit_id)?$ad->unit->unit:'-'}}</td>
                                                        <td>{{isset($ad->location)?$ad->location:'-'}}</td>
                                                        {{--                                                        <td>{{$ad->unload_qty.'-'}}{{isset($ad->unit)?$ad->unit:'-'}}</td>--}}

{{--                                                        <td>{{isset($loaded)?$loaded->location: '-'}}</td>--}}
                                                        <td>{{isset($ad)?$ad->crusher: '-'}}</td>
                                                        <td>{{isset($ad->etp_no)?$ad->etp_no:'-'}}</td>
                                                        <td>{{isset($ad->q_m)?$ad->q_m:'-'}}</td>

                                                        {{--                                                        <td>{{$ad->client_name}}</td>--}}
                                                        {{--<td>{{ $ad->is_loaded_select == 1 ?'Available':'N/A'}}</td>--}}
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
                                        </div>
                                    </form>
                                </section>
                            </div>


                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <script>

        $('.btnDelete').click(function () {
            var id = $(this).attr('id');
            var append_url = '{{ url('unloaded_items') }}/' + id + "/delete";
            $('#ConfirmBtn').attr("href", append_url);
        });

        function edit_unloaded(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit Unloaded Items');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');

            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/edit_unloaded/" + id;
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: editurl,
                // data: '{"data":"' + id + '"}',
                data: {id: id},
                success: function (data) {
                    $('#modal_body').html(data);
                },
                error: function (xhr, status, error) {
                    $('#modal_body').html(xhr.responseText);
                    //$('#modal_body').html("Technical Error Occured!");
                }
            });
        }
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