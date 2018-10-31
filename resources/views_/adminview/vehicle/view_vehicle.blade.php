@extends('adminlayout.adminmaster')

@section('title','List of Vehicles')

@section('content')
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">

                <section id="menu2">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       List of Vehicles
                                    {{--<a class="btn btn-default add-user pull-right"><i
                                                class="mdi mdi-plus"></i> Create New Vehicle</a>--}}
                                    <a class="btn-group pull-right single_viewall_btn add-user">
                                <button type="button" class="btn btn-default btn-sm res_btn"><span
                                            class="mdi mdi-plus"></span></button>
                                <button type="button" class="btn btn-default btn-sm res_btn">New Vehicle</button>
                            </a>

                    </span>
                                <section id="user_table">
                                    <table class="table table-bordered dataTable table-striped" id="example">
                                        <thead>
                                        <tr>
                                            <th class="hidden">Id</th>
                                            <th>Vehicle No</th>
                                            <th>Loaded Status</th>
                                            <th class="options">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($vehicles)>0)
                                            @foreach($vehicles as $vehicle)
                                                <tr>
                                                    <td class="hidden">{{$vehicle->id}}</td>
                                                    <td>{{$vehicle->vehicle_no}}</td>
                                                    <td>@if($vehicle->is_loaded==1)
                                                            <label for="" class="label label-danger">Loaded</label>
                                                        @else
                                                            <label for="" class="label label-success">Free</label>
                                                        @endif</td>
                                                    <td id="{{$vehicle->id}}">
                                                        <a href="#" id="{{$vehicle->id}}"
                                                           class="btn btn-xs btn-default edit-unit_"
                                                           title="Edit unit">
                                                            <span class="fa fa-pencil"></span></a>
                                                        {{--@if($_SESSION['user_master']->id != $user_master->id)--}}

                                                        <button type="button" id="{{ $vehicle->id }}"
                                                                onclick="ShowConformationPopupMsg('Are you sure you want to delete this vehicle');"
                                                                class="btn btn-xs btn-danger btnDelete"
                                                                title="Inactivate"><span class="fa fa-trash-o"
                                                                                         aria-hidden="true"></span>
                                                        </button>
                                                        {{--@endif--}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2">
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

        $('.btnDelete').click(function () {
            var id = $(this).attr('id');
            var append_url = '{{ url('vehicle') }}/' + id + "/delete";
            $('#ConfirmBtn').attr("href", append_url);
        });

        $(".add-user").click(function () {
            $('#myModal').modal('show');
            $('.modal-title').html('Add New Vehicle');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');
            //alert(id);
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "{{ url('vehicle/create') }}",
                success: function (data) {
                    $('#modal_body').html(data);
//            $('#modelBtn').visible(disabled);
                },
                error: function (xhr, status, error) {
                    $('#modal_body').html(xhr.responseText);
                    //$('#modal_body').html("Technical Error Occured!");
                }
            });

        });
        $(".edit-unit_").click(function () {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit Vehicle');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');

            var id = $(this).attr('id');
            var editurl = '{{ url('/') }}' + "/vehicle/" + id + "/edit";
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
                    //$('#modal_body').html("Technical Error Occured!");
                }
            });
        });
        $(document).ready(function () {
            var table = $('#dataTable').DataTable({
                "columnDefs": [
                    {"width": "20px", "targets": 0}
                ]
            });

            $('.datatable-col').on('keyup change', function () {
                table.column($(this).attr('id')).search($(this).val()).draw();
            });
        });

    </script>
@stop
