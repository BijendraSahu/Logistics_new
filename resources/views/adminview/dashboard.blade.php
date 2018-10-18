@extends('adminlayout.adminmaster')

@section('title','Dashboard')

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

    </style>
@stop
@section('content')
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">
                <section id="menu1">
                    <div class="home_brics_row">
                        <div class="col-sm-3 brics_res_used" style="cursor: pointer;" onclick="location.href='{{url('users')}}';">
                            <div class="white_brics">
                                <div class="white_icon_withtxt">
                                    <div class="white_icons_blk"><i class="mdi mdi-account-multiple-outline"></i></div>
                                    <div class="white_brics_txt">Users</div>
                                    <div class="white_brics_count">{{$total_user}}</div>
                                </div>
                                <div class="brics_progress white_brics_border_clr1"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 brics_res_used" style="cursor: pointer;" onclick="location.href='{{url('users')}}';">
                            <div class="white_brics">
                                <div class="white_icon_withtxt">
                                    <div class="white_icons_blk white_brics_clr2"><i
                                                class="mdi mdi-account-multiple-outline"></i></div>
                                    <div class="white_brics_txt">Staffs</div>
                                    <div class="white_brics_count">{{$total_staff}}</div>
                                </div>
                                <div class="brics_progress white_brics_border_clr2" style="
"></div>
                            </div>

                        </div>
                        <div class="col-sm-3 brics_res_used" style="cursor: pointer;" onclick="location.href='{{url('users')}}';">
                            <div class="white_brics">
                                <div class="white_icon_withtxt">
                                    <div class="white_icons_blk white_brics_clr3"><i
                                                class="mdi mdi-account-multiple-outline"></i></div>
                                    <div class="white_brics_txt">Supervisor</div>
                                    <div class="white_brics_count">{{$total_supervisor}}</div>
                                </div>
                                <div class="brics_progress white_brics_border_clr3"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 brics_res_used" style="cursor: pointer;" onclick="location.href='{{url('users')}}';">
                            <div class="white_brics">
                                <div class="white_icon_withtxt">
                                    <div class="white_icons_blk white_brics_clr4"><i
                                                class="mdi mdi-account-multiple-outline"></i></div>
                                    <div class="white_brics_txt">Clients</div>
                                    <div class="white_brics_count">{{$total_client}}</div>
                                </div>
                                <div class="brics_progress white_brics_border_clr4"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="menu2">
                    <div class="col-sm-12 res_pad0">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       Recent Material Requests
                       <a class="btn-group pull-right single_viewall_btn" href="{{url('client_requests')}}">
                                <button type="button" class="btn btn-default btn-sm res_btn"><span
                                            class="mdi mdi-eye"></span></button>
                                <button type="button" class="btn btn-default btn-sm res_btn">View ALL</button>
                            </a>

                                    {{--      <a href="{{url('client_requests')}}" class="btn btn-default pull-right btn-sm"><i
                                                      class="mdi mdi-eye"></i>View ALL</a>--}}
                    </span>
                                <section id="mytablereload" class="table_main_containner">
                                    <table class="table table-striped scroll_table" id="mycattable">
                                        <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Type</th>
                                            <th>Qty/Unit</th>
                                            <th>Client</th>
                                            <th>Request Time</th>
                                            <th>Approval Status</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(count($requests)>0)
                                            @foreach($requests as $ad)
                                                <tr>
                                                    <td>{{isset($ad->material_id)?$ad->material->name:'-'}}</td>
                                                    <td>{{isset($ad->material_type_id)?$ad->material_type->type:'-'}}</td>
                                                    <td>{{$ad->qty.'-'}}{{isset($ad->unit_id)?$ad->unit->unit:'-'}}</td>
                                                    <td>{{$ad->client->name}}</td>
                                                    <td>{{ date_format(date_create($ad->created_time), "d-M-Y h:i A")}}</td>
                                                    <td>@if($ad->is_approved=='0')
                                                            <div class='status pending'>Pending</div>
                                                        @else
                                                            <div class='status approved'>Approved</div>
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
                                    <div align="center">
                                    </div>
                                </section>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 res_pad0">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       Recent Material Loads
                                    {{--  <a href="{{url('loaded_items')}}" class="btn btn-default pull-right btn-sm"><i
                                                  class="mdi mdi-eye"></i>View ALL</a>--}}
                                    <a class="btn-group pull-right single_viewall_btn" href="{{url('loaded_items')}}">
                                <button type="button" class="btn btn-default btn-sm res_btn"><span
                                            class="mdi mdi-eye"></span></button>
                                <button type="button" class="btn btn-default btn-sm res_btn">View ALL</button>
                            </a>
                    </span>
                                <section id="mytablereload" class="table_main_containner">
                                    <table class="table table-striped scroll_table" id="mycattable">
                                        <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Type</th>
                                            <th>Load Qty/Unit</th>
                                            <th>Destination Location</th>
                                            <th>Loaded Time</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(count($loaded_items)>0)
                                            @foreach($loaded_items as $ad)
                                                <tr>
                                                    <td>{{isset($ad->material_id)?$ad->material->name:'-'}}</td>
                                                    <td>{{isset($ad->material_type_id)?$ad->material_type->type:'-'}}</td>
                                                    <td>{{$ad->load_qty.'-'}}{{isset($ad->unit_id)?$ad->unit->unit:'-'}}</td>
                                                    <td>{{$ad->destination_address}}</td>
                                                    <td>{{ date_format(date_create($ad->loaded_time), "d-M-Y h:i A")}}</td>
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
                                    <div align="center">
                                    </div>
                                </section>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    {{--////////////////////////////////////////////////*****Start Menu 3******//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
    <script>

    </script>


    {{--////////////////////////////////////////////////*****End Menu 3******//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}

    {{--////////////////////////////////////////////////*****Start Menu 2******//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
    {{--<script>
        function validate() {
            var cat_name = $('#cat_name').val();
            var cat_description = $('#cat_description').val();
            if (cat_name == "") {
                $('#cat_name').addClass("w3-border-red");
                return false;
            }
            else if (cat_description == "") {
                $('#cat_description').addClass("w3-border-red");
                return false;

            }
            else {
                sendcat();
            }
        }

        function sendcat() {
            var cat_name = $('#cat_name').val();
            var cat_description = $('#cat_description').val();
            $.ajax({
                type: "post",
                url: "{{url('add_cat')}}",
                data: "cat_name= " + cat_name + "&cat_description= " + cat_description,
                success: function (data) {
                    $('#snackbar').html('');
                    $('#snackbar').html('Categories added successfully');
                    $('#myModal').modal('hide');
                    myFunction();
                    $("#item_form").load(location.href + " #item_form");
                    $("#mytablereload").load(location.href + " #mytablereload");

                },
                error: function (data) {

                }
            });
        }

        $(document).ready(function () {
            $('#open_item_form').click(function () {
                $('#item_list').hide();
                $('#item_form').show();
            });
            $('#open_modal').click(function () {
                $('#myheader').html('');
                $('#mybody').html('');
                $('#myfooter').html('');
                $('#myheader').append('<div><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Add Categories</h4></div>');
                $('#mybody').append('<div class="panel-body dash_table_containner"><input type="text" class="form-control vRequiredTex" name="cat_name" placeholder="Enter Your Category Name " id="cat_name"><p class="clearfix"></p><textarea name="cat_description" id="cat_description" class="form-control vRequiredTex" rows="4" cols="50" placeholder="Enter Your Description "></textarea></p></div>');
                $('#myfooter').append('<button id="add_btn" type="button" class="btn btn-default" data-dismiss="modal">Close</button><button onclick="validate();" class="btn btn-primary">Add</button>');
                $('#myModal').modal();
            });
        });

    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);

        }

        function abcd($id) {
            $('.edittable' + $id).attr('contenteditable', 'true');
            $('.edit' + $id).hide();
            $('.update' + $id).show();

        }
        function abcdd($id) {
            $('.edittable' + $id).attr('contenteditable', 'false');
            $('.edit' + $id).show();
            $('.update' + $id).hide();

        }
        function abcddd($id) {
            $('.edittable' + $id).attr('contenteditable', 'false');
            $('.edit' + $id).show();
            $('.update' + $id).hide();
            $('.hiderow' + $id).hide();

        }
        function update(dis, id) {
            var ID = id;
            var name = $(dis).parent().parent("#" + id).children('.name').html();
            var slug = $(dis).parent().parent("#" + id).children('.slug').html();
            var des = $(dis).parent().parent("#" + id).children('.description').html();
            /*alert(ID+one+two+three);*/
            $.ajax({
                type: "post",
                url: "{{url('updatecat')}}",
                data: "name= " + name + "&slug= " + slug + "&des= " + des + "&ID= " + ID,
                success: function (data) {
                    abcdd(ID);
                    $('#snackbar').html('');
                    $('#snackbar').html('Categories Updated successfully');
                    myFunction();
                    $("#item_form").load(location.href + " #item_form");


                },
                error: function (data) {
                    alert("Error")
                }
            });


        }
        function deletecat(id) {
            var ID = id;
            $.ajax({
                type: "post",
                url: "{{url('deletecat')}}",
                data: "&ID= " + ID,
                success: function (data) {
                    abcddd(ID);
                    $('#snackbar').html('')
                    $('#snackbar').html('Successfully Deleted');
                    myFunction();
                    $("#item_form").load(location.href + " #item_form");

                },
                error: function (data) {
                    alert("Error")
                }
            });

        }

    </script>--}}
    {{--///////////////////////////////////////////////////////////////////*****end Menu2*****//////////////////////////////////////////////////////////////////////////////////////////////////--}}
@stop
{{--$("#item_form").load(location.href + " #item_form");--}}
{{--window.location.reload();--}}
