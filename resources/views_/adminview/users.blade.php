@extends('adminlayout.adminmaster')

@section('title', 'Users List')

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

        .post_imgblock_admin {
            position: static;
            width: 40px;
            left: 15px;
            border-radius: 50%;
            text-align: center;
            height: 40px;
            overflow: hidden;
            border: 3px solid #fff;
            box-shadow: 5px 8px 20px rgba(199, 199, 199, 0.19), 0 2px 5px rgba(107, 100, 100, 0.23);
            -webkit-box-shadow: 5px 8px 20px rgba(199, 199, 199, 0.19), 0 2px 5px rgba(107, 100, 100, 0.23);
            background-color: #ffffff;
        }

    </style>
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">

                <section id="menu2">
                    <div class="col-sm-12 col-md-12 col-xs-12 res_pad0">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       List of Users
                    </span>

                                <section id="user_table" class="table_main_containner">
                                    <table class="table table-striped table-bordered dataTable scroll_table"
                                           id="example">
                                        <thead>
                                        <tr>
                                            <th class="width_10">Profile</th>
                                            <th class="width_10">Type</th>
                                            <th class="width_12">Name</th>
                                            <th class="width_10">Contact</th>
                                            <th class="width_10">Company</th>
                                            <th class="width_10">Active Status</th>
                                            <th class="width_10">Verify Status</th>
                                            <th class="width_10">Option</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($users)>0)
                                            @foreach($users as $ad)
                                                <tr>
                                                    <td>
                                                        <div class="post_imgblock_admin">
                                                            @if(isset($ad->profile_img))
                                                                <img src="{{url('').'/'.$ad->profile_img}}"
                                                                     style="height: 100%;"/>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{$ad->user_type}}</td>
                                                    <td>{{$ad->name}}</td>
                                                    <td>{{$ad->contact}}</td>
                                                    <td>{{$ad->company_name}}</td>
                                                    <td>@if($ad->is_active=='0')
                                                            <div class='status rejected'>Inactive</div>
                                                        @else
                                                            <div class='status approved'>Active</div>
                                                        @endif
                                                    </td>
                                                    <td>@if($ad->is_verified=='0')
                                                            <div class='status pending'>Pending</div>
                                                        @else
                                                            <div class='status approved'>Verified</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($ad->is_active=='0')
                                                            <button type="button" id="{{ $ad->id }}"
                                                                    onclick="ShowConformationPopupMsg('Are you sure you want to active this user');"
                                                                    class="btn btn-xs option_grid_btn btn-success btnActive"
                                                                    title="Activate"><span
                                                                        class="mdi mdi-check" aria-hidden="true"></span>
                                                                Activate
                                                            </button>

                                                        @else
                                                            <button type="button" id="{{ $ad->id }}"
                                                                    onclick="ShowConformationPopupMsg('Are you sure you want to inactive this user');"
                                                                    class="btn btn-xs option_grid_btn btn-danger btnInactive"
                                                                    title="Inactivate"><span class="mdi mdi-close"
                                                                                             aria-hidden="true"></span>
                                                                Inactivate
                                                            </button>
                                                        @endif
                                                        <button id="{{$ad->id}}" onclick="update_user(this);"
                                                                class="btn btn-sm btn-default edit-user_"
                                                                title="Edit User">
                                                            <span class="fa fa-pencil"></span> Edit
                                                        </button>
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
        $('.btnActive').click(function () {
            var id = $(this).attr('id');
            var append_url = '{{ url('users') }}/' + id + "/active";
            $('#ConfirmBtn').attr("href", append_url);
        });

        $('.btnInactive').click(function () {
            var id = $(this).attr('id');
            var append_url = '{{ url('users') }}/' + id + "/inactive";
            $('#ConfirmBtn').attr("href", append_url);
        });

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

        function update_user(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit User');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/users/" + id + "/edit";
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: editurl,
                data: '{"data":"' + id + '"}',
                success: function (data) {
                    $('#modal_body').html(data);
                },
                error: function (xhr, status, error) {
                    $('#modal_body').html(xhr.responseText);
                }
            });
        }
    </script>

@stop