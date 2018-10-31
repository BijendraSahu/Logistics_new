<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['admin_master'])) {
//    echo 'Please Login';
    return view('adminview.adminlogin');
}
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="images/png" href="{{url('images/dashbaord_fevicon.png')}}"/>
    <link rel="stylesheet" href="{{url('css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{url('css/materialdesignicons.min.css')}}"/>
    <link rel="stylesheet" href="{{url('css/Dashboard.css')}}"/>
    <link rel="stylesheet" href="{{url('css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{url('css/media.css')}}"/>
    <link rel="stylesheet" href="{{url('css/form-wizard-green.css')}}">
    <script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>
    <script src="{{url('js/Global.js')}}"></script>
    <script src="{{url('js/sweetalert.min.js')}}"></script>
    <link href="{{ url('css/datepicker.css') }}" rel="stylesheet">
    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('js/dataTables.bootstrap.min.js')}}"></script>
    {{--    <link href="{{ url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">--}}
    {{--    <link href="{{ url('https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">--}}
    {{--    <link href="{{ url('https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css') }}" rel="stylesheet">--}}

    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        });
    </script>
    <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"/>
    <script type="text/javascript">
        function HideTranparent() {
            $('.overlay_res').fadeOut();
            $('.dash_sidemenu').removeClass('dash_sidemenu_show');
            $('body').css('overflow', 'auto');
        }

        function ResponsiveMenuClick() {

            $('.overlay_res').fadeIn();
            $('.dash_sidemenu').addClass('dash_sidemenu_show');
            $('body').css('overflow', 'hidden');
        }

        $(document).ready(function () {
            /*date Picker*/
            /* $('.glo_date').datepicker({
             format: 'dd-M-yyyy', autoclose: true
             }).on('changeDate', function (event) {
             if ($('#date_of_birth').val() != "") {
             $("#date_of_birth").removeClass('vErrorRed');
             }
             });
             /!*-----Time Picker-----*!/
             $('.glo_timepicker').timepicker();
             /!*--------Autocomplete ------*!/
             $('.Glo_autocomplete').select2();
             /!*----Header Tooltip--------*!/*/
            // Tooltip jquery
            $('.grid_title').hover(function () {
                var headtxt = $(this).text();
                var left = $(this).offset().left;
                var top = $(this).offset().top;
                $('.icon_tp').css('margin', '0px');
                $('.icon_tp').show();
                $('.icon_txt').text(headtxt);
                $('.icon_tp').css("top", top - 30);
                $('.icon_tp').css("left", left);
            });
            $('.grid_title').mouseout(function () {
                $('.icon_tp').hide();
            });
        });

        function MenuClick(dis) {
            $('.dash_sub_menu').slideUp();
            $('.right_menu_li').find('i').removeClass('mdi-chevron-down');
            $('.right_menu_li').find('i').addClass('mdi-chevron-right');
            if ($(dis).find('.dash_sub_menu').is(':visible')) {
                $(dis).find('.dash_sub_menu').slideUp();
                $(dis).find('i').removeClass('mdi-chevron-down');
                $(dis).find('i').addClass('mdi-chevron-right');
            }
            else {
                $(dis).find('.dash_sub_menu').slideDown();
                $(dis).find('i').removeClass('mdi-chevron-right');
                $(dis).find('i').addClass('mdi-chevron-down');
            }
        }

        function GridHeaderCheck(dis) {
            $('input[type="checkbox"]').prop("checked", $(dis).prop("checked"));
        }
    </script>
    <style type="text/css">
        html {
            background: #e5e5e5;
        }

        .errorClass {
            border: 1px solid red;
        }

        .input-lg {
            font-size: 16px;
        }

        #snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 55;
            left: 11%;
            bottom: 22px;
            border-radius: 14px;
            font-size: 17px;
        }

        #snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }
            to {
                bottom: 22px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }
            to {
                bottom: 22px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 22px;
                opacity: 1;
            }
            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 22px;
                opacity: 1;
            }
            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>
    <script type="text/javascript">
        function myFunction() {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);

        }
    </script>
    <script type="text/javascript">
        function toggleFullScreen(elem) {
            if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
                if (elem.requestFullScreen) {
                    elem.requestFullScreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullScreen) {
                    elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
                $('.expand_on').hide();
                $('.expand_off').show();
                $('#fixed_nav').addClass('on_fullscreen_fixed');
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                $('.expand_on').show();
                $('.expand_off').hide();
                $('#fixed_nav').removeClass('on_fullscreen_fixed');
            }
        }

        function MenuShift(dis) {
            var checkclass = $('#page_body').attr('class');
            if (checkclass == "body_color") {
                $('#page_body').addClass('collapse_side');
                $(dis).find('.left_show').show();
                $(dis).find('.right_show').hide();
            } else {
                $('#page_body').removeClass('collapse_side');
                $(dis).find('.right_show').show();
                $(dis).find('.left_show').hide();
            }
        }
    </script>
    {{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
    {{--   <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>--}}


    @yield('head')
</head>
<body class="body_color" id="page_body">
<nav class="top_navigationbar" id="fixed_nav">
    <div class="dash_menuicon" onclick="ResponsiveMenuClick();"><i class="mdi mdi-menu"></i>
    </div>
    <div class="option-container">
        <div class="user-info glo_menuclick">
            <span class="name_show">{{$_SESSION['admin_master']->name}}</span>
            <span class="caret"></span>
            <div class="menu_basic_popup menu_popup_setting effect scale0">
                <div class="menu_popup_containner padding0">
                    <div class="menu_popup_settingrow effect" onclick="ChangePasswordShow()" data-toggle="modal"
                         data-target="#update_password">
                        <a href="#" class="menu_setting_row">
                            <i class="mdi mdi-lock-open-outline global_color"></i>
                            Change Password
                        </a>
                    </div>
                    <div class="menu_popup_settingrow effect">
                        <a href="{{url('logoutadmin')}}" class="menu_setting_row">
                            <i class="mdi mdi-logout global_color"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="expand_block" onclick="toggleFullScreen(document.body)">
            <i class="mdi mdi-arrow-expand-all expand_on"></i>
            <i class="mdi mdi-arrow-collapse-all expand_off"></i>
        </div>
    </div>
</nav>
<div id="update_password" class="modal fade in" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="signup-modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-lock" style="
    margin-right: 5px;
"></span> UPDATE PASSWORD ?</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input type="password" class="form-control input-lg" placeholder="Old Password"
                               placeholder="Old Password"
                               id="txtChange_previousPsd" autocomplete="off" data-validate="TT_btnChangepass"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input id="txtchange_newPsd" type="password"
                               autocomplete="off" name="newpassword" data-validate="TT_btnChangepass"
                               class="form-control input-lg" placeholder="Enter Password" required=""
                               data-parsley-length="[6, 30]" data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input id="txtchange_retypePsd" type="password" name="confirmpassword" autocomplete="off"
                               data-validate="TT_btnChangepass" class="form-control input-lg"
                               placeholder="Retype Password" required="" data-parsley-equalto="#passwd"
                               data-parsley-trigger="keyup">
                    </div>
                </div>
                <p class="statusMsg"></p>
                <button onclick="submitChange();" id="TT_btnChangepass" class="btn btn-success btn-block btn-lg">UPDATE
                    PASSWORD
                </button>
            </div>
        </div>
    </div>
</div>

{{--<div id="myModal_UpdatePassword" data-toggle="modal" data-easein="bounceIn" class="connect_LBbox modal fade in"
     role="dialog"
     aria-hidden="false">
    <div class="modal-dialog forgotpass_lb">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="GloCloseModel();">×</button>
                <h4 class="modal-title">UPDATE PASSWORD ?</h4>
            </div>
            <div class="modal-body">
                <div class="basic_lb_row">
                    <input type="text" class="form-control forgot_txt" placeholder="Old Password"
                           id="txtChange_previousPsd" autocomplete="off" data-validate="TT_btnChangepass">
                    <div class="forgot_icon"><i class="mdi mdi-lock mdi-16px"></i></div>
                </div>
                <div class="basic_lb_row">
                    <input type="password" class="form-control forgot_txt" placeholder="New Password"
                           id="txtchange_newPsd"
                           autocomplete="off" name="newpassword" data-validate="TT_btnChangepass">
                    <div class="forgot_icon"><i class=" mdi mdi-lock-open-outline mdi-16px"></i></div>
                </div>
                <div class="basic_lb_row">
                    <input type="password" class="form-control forgot_txt" placeholder="Re-type Password"
                           id="txtchange_retypePsd" name="confirmpassword" autocomplete="off"
                           data-validate="TT_btnChangepass">
                    <div class="forgot_icon"><i class=" mdi mdi-lock-open-outline mdi-16px"></i></div>
                </div>
                <p class="statusMsg"></p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" onclick="submitChange();" class="btn btn-primary" id="TT_btnChangepass">Update
                </button>
            </div>
        </div>

    </div>
</div>--}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" id="myheader">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal_title">Modal Header</h4>
            </div>
            <div class="modal-body edit_item_container" id="modal_body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer" id="myfooter">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<aside class="dash_sidemenu">
    <div class="shift_iconbox" onclick="MenuShift(this);">
        <i class="mdi mdi-arrow-left-bold right_show"></i>
        <i class="mdi mdi-arrow-right-bold left_show"></i>
    </div>
    <div class="logo_block">
        <img src="{{url('images/Retinodes_logo.png')}}" class="big_aside_icon"/>
        <img src="{{url('images/dashbaord_fevicon.png')}}" class="small_aside_icon"/>
    </div>
    <div class="dash_emp_details">
        <img src="{{url('images/Admin_pic.jpg')}}" class="dash_profile_img"/>
        <div class="dash_emp_basic">
            <span class="dash_name">{{ucfirst($_SESSION['admin_master']['username'])}}</span>
        </div>
    </div>
    <ul class="list-group dash_menu_ul style-scroll">
        <li class="right_menu_li">
            <a href="{{url('/admin')}}">
                <i class="dash_arrow mdi mdi-speedometer global_color"></i>
                <span class="aside_menu_txt">Dashboard</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('users')}}">
                <i class="dash_arrow mdi mdi-account-box global_color"></i>
                <span class="aside_menu_txt">Users</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('client_requests')}}">
                <i class="dash_arrow mdi mdi-database global_color"></i>
                <span class="aside_menu_txt">Client Requests</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('loaded_items')}}">
                <i class="dash_arrow mdi mdi-bus global_color"></i>
                <span class="aside_menu_txt">Loaded Items</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('unloaded_items')}}">
                <i class="dash_arrow mdi mdi-bus-school global_color"></i>
                <span class="aside_menu_txt">Unloaded Items</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('comparision')}}">
                <i class="dash_arrow mdi mdi-compare global_color"></i>
                <span class="aside_menu_txt">Comparision</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('petrol_requests')}}">
                <i class="dash_arrow mdi mdi-receipt global_color"></i>
                <span class="aside_menu_txt">Petrol Requests</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('unit')}}">
                <i class="dash_arrow mdi mdi-unity global_color"></i>
                <span class="aside_menu_txt">Units</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('location')}}">
                <i class="dash_arrow mdi mdi-account-location global_color"></i>
                <span class="aside_menu_txt">Location</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('material')}}">
                <i class="dash_arrow mdi mdi-content-duplicate global_color"></i>
                <span class="aside_menu_txt">Materials</span>
            </a>
        </li>
        <li class="right_menu_li">
            <a href="{{url('material_type')}}">
                <i class="dash_arrow mdi mdi-image-area-close global_color"></i>
                <span class="aside_menu_txt">Material Types</span>
            </a>
        </li>

        <li class="right_menu_li">
            <a href="{{url('vehicle')}}">
                <i class="dash_arrow mdi mdi-bike global_color"></i>
                <span class="aside_menu_txt">Vehicle</span>
            </a>
        </li>


    </ul>
</aside>
<div class="modal popup_bgcolor" id="conformation_popup">
    <div class="popup_box">
        <div class="alert_popup conformation_bg">
            <div class="popup_verified"><i class="mdi mdi-close"></i></div>
            <h4 class="popup_mainhead">Confirmation Massage!</h4>
            <p class="popup-text dynamic_popuptxt">Do you really want to delete this record.t</p>
        </div>
        <div class="popup_submit">
            <a class="popup_submitbtn conformation_bg conformation_btn" type="submit" id="ConfirmBtn"
               onclick="HidePopoupMsg();">Yes
            </a>
            <a class="popup_submitbtn conformation_nobtn" type="submit" onclick="HidePopoupMsg();">No</a>
        </div>
    </div>
</div>
<p id="err1"></p>
@yield('content')
<div class="overlay_res" onclick="HideTranparent();"></div>
<div id="snackbar">New Categories added Successfully</div>
<script src="{{ url('js/bootstrap-datepicker.js') }}"></script>
{{--<script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>--}}
{{--<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>--}}
<script src="{{ url('js/jquery.table2excel.js') }}"></script>
{{--<script src="{{ url('https://code.jquery.com/jquery-3.3.1.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js') }}"></script>--}}
{{--<script src="{{ url('https://code.jquery.com/jquery-3.3.1.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js') }}"></script>--}}
{{--<script src="{{ url('https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js') }}"></script>--}}

<script type="text/javascript">
    $(function () {
        $('.dtp').datepicker({
            format: "dd-MM-yyyy",
            maxViewMode: 2,
            todayBtn: "linked",
            daysOfWeekHighlighted: "0",
            autoclose: true,
            todayHighlight: true
        });
    });
    //    $(document).ready(function () {
    //        $('#example').DataTable( {
    //            dom: 'Bfrtip',
    //            buttons: [
    //                {
    //                    extend: 'copyHtml5',
    //                    exportOptions: {
    //                        columns: [ 0, ':visible' ]
    //                    }
    //                },
    //                {
    //                    extend: 'excelHtml5',
    //                    exportOptions: {
    //                        columns: ':visible'
    //                    }
    //                },
    //                {
    //                    extend: 'pdfHtml5',
    //                    exportOptions: {
    //                        columns: [ 0, 1, 2, 5 ]
    //                    }
    //                },
    //                'colvis'
    //            ]
    //        } );
    //    });
    $(document).ready(function () {
//        $('#myloaderid').hide();
        $('[data-toggle="tooltip"]').tooltip();
        var table = $('#example').DataTable({
            "columnDefs": [
                {"width": "20px", "targets": 0}
            ],
            "order": [[0, "desc"]]
        });

        $('.datatable-col').on('keyup change', function () {
            table.column($(this).attr('id')).search($(this).val()).draw();
        });
    });

    function submitChange() {
        var oldpassword = $('#txtChange_previousPsd').val();
        var newpassword = $('#txtchange_newPsd').val();
        var confirmpassword = $('#txtchange_retypePsd').val();
        var formData = '_token=' + $('.token').val();
        if (newpassword.trim() == '') {
            swal("Oops", "Please enter new password..", "error");
            return false;
        } else if (confirmpassword.trim() == '') {
            swal("Oops", "Please enter confirm password..", "error");
            return false;
        } else if (confirmpassword.trim() != newpassword.trim()) {
            swal("Oops", "Password Mismatch..", "error");
            return false;
        } else {
            $.ajax({
                type: "POST",
                contentType: "application/json; charset=utf-8",
                url: "{{ url('change_password') }}",
//                data: '{"data":"' + endid + '"}',
                data: '{"formData":"' + formData + '", "newpassword":"' + newpassword + '", "confirmpassword":"' + confirmpassword + '", "oldpassword":"' + oldpassword + '"}',
                success: function (data) {
                    if (data == 'ok') {
                        $('#txtChange_previousPsd').val('');
                        $('#txtchange_newPsd').val('');
                        $('#txtchange_retypePsd').val('');
                        swal("Success!", "Password has been changed...", "success");
                        $('#myModal_UpdatePassword').modal('toggle');
                    } else if (data == 'Incorrect') {
                        $('#txtChange_previousPsd').val('');
                        swal("Oops", "Incorrect current password...", "error");
                    }
                },
                error: function (xhr, status, error) {
                    // swal("Oops", "Server Error...", "error");
                    $('#myModal_UpdatePassword').html(xhr.responseText);
                }
            });
        }
    }
    function exporttoexcel() {
        $("#example").table2excel({
            filename: "client_request.csv"
        });
    }

</script>
@if(session()->has('message'))
    <script type="text/javascript">
        setTimeout(function () {
            {{--            ShowSuccessPopupMsg('{{ session()->get('message') }}');--}}
            swal("Success!", "{{ session()->get('message') }}", "success");

        }, 500);
    </script>
@endif
@if($errors->any())
    <script type="text/javascript">
        setTimeout(function () {
            swal("Oops!", "{{$errors->first()}}", "error");
            {{--ShowErrorPopupMsg('{{$errors->first()}}');--}}
        }, 500);
    </script>
@endif
</body>
</html>
