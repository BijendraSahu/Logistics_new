@extends('adminlayout.adminmaster')

@section('title', 'Loaded Item List')

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
                       Loaded Item List
                                    <button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();"><i
                                                class="mdi mdi-download"></i> Download Excel</button>

                    </span>
                                <section id="user_table" class="table_main_containner">
                                    <form action="{{url('loaded_items')}}" method="post" enctype="multipart/form-data">
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
                                                <a href="{{url('loaded_items')}}" class="btn btn-success">Refresh</a>
                                            </div>
                                        </div>
                                    </form>
                                    <br>

                                    <form action="{{ url('loaded_items_delete') }}" method="post" id="loaded_frm"
                                          onSubmit="if(!confirm('Are you sure you want to delete selected record?')){return false;}">
                                        {{--<button type="button"--}}
                                        {{--onclick="ShowConformationPopupMsg('Are you sure you want to delete this loaded Item');"--}}
                                        {{--class="btn btn-xs btn-danger btnDelete"--}}
                                        {{--title="Inactivate"><span class="fa fa-trash-o"--}}
                                        {{--aria-hidden="true"></span>--}}
                                        {{--Delete--}}
                                        {{--</button>--}}
                                        <div class="btn-div">
                                        <input type="submit" name="submit" class="btn btn-danger btn_post btn-cancel"
                                               value="Delete"/>
                                        </div>
                                        <div class="table-scroll style-scroll">
                                        <table class="table table-bordered dataTable table-striped scroll_table"
                                               id="example">
                                            <thead>
                                            <tr>
                                                <th class="hidden">Id</th>
                                                <th class="width_10">Select Delete</th>
                                                <th class="width_10">Loaded Time</th>
                                                <th class="width_15">Voucher No</th>
                                                <th class="width_10">Vehicle</th>
                                                <th class="width_15">Material</th>
                                                <th class="width_10">Type</th>
                                                <th class="width_10">Load Qty/Unit</th>
                                                <th class="width_10">Destination Location</th>
                                                {{--<th class="width_15">Estimate Delivery Time</th>--}}
                                                {{--<th class="width_10">Delay Time</th>--}}
                                                <th class="width_10">Supervisor</th>
                                                <th class="width_15">ETP No </th>
                                                <th class="width_15">Q/M</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($loaded_items)>0)
                                                @foreach($loaded_items as $ad)
                                                    <?php
                                                    //                                                                                                    date_default_timezone_set('Asia/Calcutta');
                                                    //                                                                                                    $date = \Illuminate\Support\Carbon::now();
                                                    //                                                                                                    $date2 = $ad->estimate_deliver_time;
                                                    //                                                                                                    $date1 = date_create("$date");
                                                    //                                                                                                    $date2 = date_create("$date2");
                                                    //                                                                                                    $dteDiff = $date->diff($date2);
                                                    //                                                                                                    $unloaded_time = \Illuminate\Support\Facades\DB::selectOne("SELECT unloaded_time FROM client_unload where vehicle_id = $ad->vehicle_id order BY id DESC limit 1");
                                                    //                                                                                                    $delay = isset($unloaded_time) ? $date->diff(date_create($unloaded_time->unloaded_time)) : '-';
                                                    //                                                                                                    print $dteDiff->format("%H:%I:%S");
                                                    ?>
                                                    <tr>
                                                        <td class="hidden">{{$ad->id}}</td>
                                                        <td>
                                                            <input type="checkbox" value="{{$ad->id}}"
                                                                   name="loaded_id[]"/>
                                                            <button type="button" onclick="edit_loaded(this)"
                                                                    id="{{$ad->id}}"
                                                                    class="btn btn-primary btn-edit">Edit
                                                            </button>
                                                        </td>
                                                        <td>{{ date_format(date_create($ad->loaded_time), "d-M-Y h:i A")}}</td>
                                                        <td>{{isset($ad->challan_no)?$ad->challan_no:'N/A'}}</td>
                                                        <td>{{isset($ad->vehicle->vehicle_no)?$ad->vehicle->vehicle_no:'-'}}</td>
                                                        <td>{{isset($ad->material_id)?$ad->material->name:'-'}}</td>
                                                        <td>{{isset($ad->material_type_id)?$ad->material_type->type:'-'}}</td>
                                                        <td>{{$ad->load_qty.'-'}}{{isset($ad->unit_id)?$ad->unit->unit:'-'}}</td>
                                                        <td>{{$ad->destination_address}}</td>
                                                        {{--                                                    <td>{{ date_format(date_create($ad->estimate_deliver_time), "d-M-Y h:i A")}}</td>--}}
                                                        {{--<td>--}}
                                                        {{--<div class="status rejected">{{isset($unloaded_time)?$delay->format("%D Day-%H:%i:%s") :$dteDiff->format("%D Day-%H:%i:%s")}}</div>--}}
                                                        {{--</td>--}}
                                                        <td>{{isset($ad->supervisor->name)?$ad->supervisor->name:''}}</td>
                                                        <td>{{isset($ad->etp_no)?$ad->etp_no:'-'}}</td>
                                                        <td>{{isset($ad->q_m)?$ad->q_m:'-'}}</td>
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

        // $('.btnDelete').click(function () {
        {{--var id = $(this).attr('id');--}}
        {{--var append_url = '{{ url('loaded_items') }}/' + id + "/delete";--}}
        {{--$('#ConfirmBtn').attr("href", append_url);--}}
        // $("#loaded_frm").submit();
        // });

        {{--$(document).ready(function () {--}}
        {{--// globalloadershow();--}}
        {{--$("#userpostForm").on('submit', function (e) {--}}
        {{--e.preventDefault();--}}
        {{--swal({--}}
        {{--title: "Are you sure?",--}}
        {{--text: "You want to delete selected items...!",--}}
        {{--icon: "warning",--}}
        {{--buttons: true,--}}
        {{--dangerMode: true,--}}
        {{--}).then((okk) => {--}}
        {{--if (okk) {--}}
        {{--$.ajax({--}}
        {{--type: 'POST',--}}
        {{--url: "{{ url('loaded_items_delete') }}",--}}
        {{--data: new FormData(this),--}}
        {{--contentType: false,--}}
        {{--cache: false,--}}
        {{--processData: false,--}}
        {{--// beforeSend: function () {--}}
        {{--//     $('#userpostForm').css("opacity", ".5");--}}
        {{--//     $(".btn_post").attr("disabled");--}}
        {{--// },--}}
        {{--success: function (data) {--}}
        {{--// HideOnpageLoopader1();--}}
        {{--swal("Success!", "Your post has been uploaded...", "success");--}}
        {{--// ShowSuccessPopupMsg('Your post has been uploaded...');--}}
        {{--// $('#image_preview').text('');--}}
        {{--// $('.emojionearea-editor').empty();--}}
        {{--// $('#post_text_emoji').text('');--}}
        {{--// $('#posttext').val('');--}}
        {{--// $('#upload_file_image').val('');--}}
        {{--// $('#upload_file_video').val('');--}}
        {{--// $('#userpostForm').css("opacity", "");--}}
        {{--// $(".btn_post").removeAttr("disabled");--}}
        {{--// latest_dashboardpostload();--}}
        {{--},--}}
        {{--error: function (xhr, status, error) {--}}
        {{--ShowErrorPopupMsg('Error in uploading...');--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
        {{--});--}}

        {{--});--}}
        {{--});--}}

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

        function edit_loaded(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit Loaded Items');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');

            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/edit_loaded/" + id;
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
    </script>

@stop