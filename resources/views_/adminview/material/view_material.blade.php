@extends('adminlayout.adminmaster')

@section('title','List of Materials')

@section('content')
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">

                <section id="menu2">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       List of Materials
                            <a class="btn btn-default add-user pull-right"><i class="mdi mdi-plus"></i> Create New Material</a>
                                    {{--<a class="btn-group pull-right single_viewall_btn">--}}
                                {{--<button type="button" class="btn btn-default btn-sm res_btn"><span class="mdi mdi-eye"></span></button>--}}
                                {{--<button type="button" class="btn btn-default btn-sm add-user res_btn">New Material</button>--}}
                            {{--</a>--}}
                    </span>
                                {{--<div id="snackbar">New Categories added Successfully</div>--}}
                                {{--<p class="clearfix"></p>--}}
                                {{--<input id='myInput' class="form-control" placeholder="search" onkeyup='searchTable()'--}}
                                {{--type='text'>--}}
                                <br>
                                <section id="user_table">
                                    <table class="table table-bordered dataTable table-striped" id="example">
                                        <thead>
                                        <tr>
                                            <th class="hidden">Id</th>
                                            <th>Material Name</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($materials)>0)
                                            @foreach($materials as $material)
                                                <tr>
                                                    <td class="hidden">{{$material->id}}</td>
                                                    <td>{{$material->name}}</td>
                                                    <td>{{isset($material->location_id)?$material->location->name:'-'}}</td>
                                                    <td id="{{$material->id}}">
                                                        <a href="#" id="{{$material->id}}"
                                                           class="btn btn-xs btn-default edit-unit_"
                                                           title="Edit unit">
                                                            <span class="fa fa-pencil"></span></a>
                                                        {{--@if($_SESSION['user_master']->id != $user_master->id)--}}

                                                        <button type="button" id="{{ $material->id }}"
                                                                onclick="ShowConformationPopupMsg('Are you sure you want to delete this unit');"
                                                                class="btn btn-xs btn-danger btnDelete"
                                                                title="Inactivate"><span
                                                                    class="fa fa-trash-o" aria-hidden="true"></span>
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
            var append_url = '{{ url('material') }}/' + id + "/delete";
            $('#ConfirmBtn').attr("href", append_url);
        });

        $(".add-user").click(function () {
            $('#myModal').modal('show');
            $('#modal_title').html('Add New Material');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');
            //alert(id);
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "{{ url('material/create') }}",
                success: function (data) {
                    $('#modal_body').html(data);
//            $('#modelBtn').visible(disabled);
                },
                error: function (xhr, status, error) {
                    $('#modal_body').html(xhr.responseText);
                    //$('.modal-body').html("Technical Error Occured!");
                }
            });

        });
        $(".edit-unit_").click(function () {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit Material');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('assets1')}}"/>');

            var id = $(this).attr('id');
            var editurl = '{{ url('/') }}' + "/material/" + id + "/edit";
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
                    //$('.modal-body').html("Technical Error Occured!");
                }
            });
        });
        $(document).ready(function () {
//            var i = 0;
//            $('#dataTable thead th').each(function () {
//                var style = 'input-sm';
//                if (i < 2)
//                    style += " hidden";
//                else
//                    style += " datatable-col";
//                var title = $(this).text();
//                $('#table_filter').append('<input id="' + i + '" type="text" class="' + style + '" placeholder="' + title + '" />');
//                i++;
//            });

// DataTable
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
