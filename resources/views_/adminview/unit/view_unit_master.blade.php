@extends('adminlayout.adminmaster')

@section('title','List of Units')

@section('content')
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">

                <section id="menu2">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       List of units
                                     <a class="btn-group pull-right single_viewall_btn add-user">
                                <button type="button" class="btn btn-default btn-sm res_btn"><span class="mdi mdi-plus"></span></button>
                                <button type="button" class="btn btn-default btn-sm res_btn">New Unit</button>
                            </a>
                                    {{--<a class="btn btn-default add-user pull-right"><i class="mdi mdi-plus"></i> Create New Unit</a>--}}

                    </span>
                                {{--<div id="snackbar">New Categories added Successfully</div>--}}
                                {{--<p class="clearfix"></p>--}}
                                {{--<input id='myInput' class="form-control" placeholder="search" onkeyup='searchTable()'--}}
                                {{--type='text'>--}}
                                <section id="user_table" class="table_main_containner">
                                    <table class="table table-bordered dataTable table-striped scroll_table" id="example">
                                        <thead>
                                        <tr>
                                            <th class="hidden">Id</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($units)>0)
                                            @foreach($units as $unit)
                                                <tr>
                                                    <td class="hidden">{{$unit->id}}</td>
                                                    <td>{{$unit->unit}}</td>
                                                    <td id="{{$unit->id}}">
                                                        <a href="#" id="{{$unit->id}}" class="btn btn-xs btn-default edit-unit_"
                                                           title="Edit unit">
                                                            <span class="fa fa-pencil"></span></a>
                                                        {{--@if($_SESSION['user_master']->id != $user_master->id)--}}

                                                        <button type="button" id="{{ $unit->id }}" onclick="ShowConformationPopupMsg('Are you sure you want to delete this unit');" class="btn btn-xs btn-danger btnDelete" title="Inactivate"><span
                                                                    class="fa fa-trash-o" aria-hidden="true"></span></button>
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
            var append_url = '{{ url('unit') }}/' + id + "/delete";
            $('#ConfirmBtn').attr("href", append_url);
        });

        $(".add-user").click(function () {
            $('#myModal').modal('show');
            $('#modal_title').html('Add New Unit');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('assets1')}}"/>');
            //alert(id);
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "{{ url('unit/create') }}",
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
            $('#modal_title').html('Edit Unit');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');

            var id = $(this).attr('id');
            var editurl = '{{ url('/') }}' + "/unit/" + id + "/edit";
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
