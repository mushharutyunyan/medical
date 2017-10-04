<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Admin Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/clockface/css/clockface.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-datepicker/css/datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link href="/assets/admin/css/tasks.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/css/error.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/css/jquery-confirm.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="/assets/admin/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/css/grey.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/assets/admin/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/map.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
        .chat{
            overflow-y: auto;
            height: 200px;
        }
    </style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner container">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/admin">
                <img src="/assets/admin/img/logo-default.png" alt="logo" class="logo-default"/>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
            <form class="search-form search-form-expanded" action="extra_search.html" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." name="query">
                    <span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
                </div>
            </form>
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-extended dropdown-inbox">
                        <a href="/admin/message" class="dropdown-toggle">
                            <i class="icon-envelope"></i>
                            <span class="badge badge-default">
                            <i class="fa fa-plus"></i></span>
                        </a>
                    </li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            @if(isset($user_notifications))
                            @if(count($user_notifications))
                                <span class="badge badge-default">{{count($user_notifications)}}</span>
                            @endif
                            @endif
                        </a>
                        <ul class="dropdown-menu">

                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    @if(isset($user_notifications))
                                    @if(count($user_notifications))
                                    @foreach($user_notifications as $user_notification)
                                    <li>
                                        <a href="/admin/userOrder">
                                            <span class="time">{{$user_notification['datetime']}}</span>
                                            <span class="details">
										<span class="label label-sm label-icon label-success">
										<i class="fa fa-plus"></i>
										</span>
                                                {{$user_notification['message']}}. </span>
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-envelope-open"></i>
                            @if(isset($unread_messages))
                            @if(count($unread_messages))
                            <span class="badge badge-default">{{count($unread_messages)}}</span>
                            @endif
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                @if(isset($unread_messages))
                                @if(count($unread_messages))
                                <h3>You have <span class="bold">{{count($unread_messages)}} New</span> Messages</h3>
                                @else
                                <h3>You don't have new Messages</h3>
                                @endif
                                @endif
                                <a href="/admin/message">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    @if(isset($unread_messages))
                                    @if(count($unread_messages))
                                        @foreach($unread_messages as $unread_message)
                                            <li>
                                                <a href="/admin/message/{{$unread_message->from}}">
                                                    <span class="photo"><img src="/assets/admin/img/avatar.png" class="img-circle" alt=""></span>
                                                    <span class="subject">
                                                        <span class="from">{{$unread_message->adminFrom->firstname}} {{$unread_message->adminFrom->lastname}}</span>
                                                        <span class="time">{{$unread_message->created_at}} </span>
                                                    </span>
                                                    <span class="message">{{ \Illuminate\Support\Str::limit($unread_message->message, 10) }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-calendar"></i>
                            @if(isset($orders))
                            @if($orders->count())
                            <span class="badge badge-default">{{$orders->count()}}</span>
                            @endif
                            @endif
                        </a>
                        <ul class="dropdown-menu extended tasks">
                            <li class="external">
                                @if(isset($orders))
                                @if($orders->count())
                                <h3>You have <span class="bold">{{$orders->count()}} pending</span> orders</h3>
                                <a href="/admin/order">view all</a>
                                @endif
                                @endif
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    @if(isset($orders))
                                    @if($orders->count())
                                        @foreach($orders as $order)
                                            <li>
                                                <a href="/admin/order">
                                                    <span class="task">
                                                        <span class="desc">
                                                            @if($order->to == Auth::guard('admin')->user()['organization_id'])
                                                                {{$order->organizationFrom->name}}
                                                            @else
                                                                {{$order->organizationTo->name}}
                                                            @endif
                                                            ({{$status[$order->status]}})
                                                        </span>

                                                        <span class="percent">{{$order->created_at}}</span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            {{--<img alt="" class="img-circle" src="../../assets/admin/layout2/img/avatar3_small.jpg"/>--}}
                            <span class="username username-hide-on-mobile">
						{{Auth::guard('admin')->user()['firstname']}} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            {{--<li>--}}
                                {{--<a href="extra_profile.html">--}}
                                    {{--<i class="icon-user"></i> My Profile </a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="page_calendar.html">--}}
                                    {{--<i class="icon-calendar"></i> My Calendar </a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="inbox.html">--}}
                                    {{--<i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">--}}
								{{--3 </span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="page_todo.html">--}}
                                    {{--<i class="icon-rocket"></i> My Tasks <span class="badge badge-success">--}}
								{{--7 </span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="divider">--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="extra_lock.html">--}}
                                    {{--<i class="icon-lock"></i> Lock Screen </a>--}}
                            {{--</li>--}}
                            <li>
                                <a href="/admin/logout">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="container">
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    @if(Auth::guard('admin')->user()['role_id'] == 1 || Auth::guard('admin')->user()->role->name == 'admin')
                    @if(Request::segment(2) == 'manage')
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="javascript:;">
                            <i class="icon-briefcase"></i>
                            <span class="title">Manage</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            @if(Request::segment(2) == 'manage' && Request::segment(3) == 'admins')
                            <li class="active">
                            @else
                            <li>
                            @endif
                                <a href="/admin/manage/admins">Admins</a>
                            </li>
                            @if(Auth::guard('admin')->user()['role_id'] == 1)
                                @if(Request::segment(2) == 'manage' && Request::segment(3) == 'roles')
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                                    <a href="/admin/manage/roles">Roles</a>
                                </li>
                                @if(Request::segment(2) == 'manage' && Request::segment(3) == 'drugs')
                                    <li class="active">
                                @else
                                <li>
                                    @endif
                                    <a href="/admin/manage/drugs">Drugs</a>
                                </li>
                            @endif
                            @if(Request::segment(2) == 'manage' && Request::segment(3) == 'organizations')
                                <li class="active">
                            @else
                                <li>
                            @endif
                                <a href="/admin/manage/organizations">Organizations</a>
                            </li>
                            @if(Request::segment(2) == 'manage' && Request::segment(3) == 'circulation')
                                <li class="active">
                            @else
                                <li>
                            @endif
                                    <a href="/admin/manage/circulation">Circulation</a>
                                </li>
                            @if(Request::segment(2) == 'manage' && Request::segment(3) == 'topRated')
                                <li class="active">
                            @else
                                <li>
                                    @endif
                                    <a href="/admin/manage/topRated">Top Rated Drugs</a>
                                </li>
                        </ul>
                    </li>
                    @if(Request::segment(2) == 'storage')
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="/admin/storage">
                            <i class="icon-basket"></i>
                            <span class="title">Storage</span>
                            <span class="arrow "></span>
                        </a>
                    </li>
                    @endif
                    @if(Request::segment(2) == 'order')
                        <li class="active">
                    @else
                        <li>
                    @endif
                            <a href="/admin/order">
                                <i class="icon-basket"></i>
                                <span class="title">Order</span>
                                <span class="arrow "></span>
                            </a>
                        </li>
                    @if(Request::segment(2) == 'userOrder')
                        <li class="active">
                    @else
                        <li>
                            @endif
                            <a href="/admin/userOrder">
                                <i class="icon-basket"></i>
                                <span class="title">User Order</span>
                                <span class="arrow "></span>
                            </a>
                        </li>
                    @if(Request::segment(2) == 'tickets')
                        <li class="active">
                    @else
                        <li>
                            @endif
                            <a href="/admin/tickets">
                                <i class="icon-basket"></i>
                                <span class="title">Tickets</span>
                                <span class="arrow "></span>
                            </a>
                        </li>
                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
        </div>
        <!-- END SIDEBAR -->
        <!-- BEIGN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <!--Cooming Soon...-->
        <!-- END QUICK SIDEBAR -->
    </div>

    <!-- END CONTAINER -->

    <div id="search_drug" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Search Drug</h4>
                </div>
                <div class="modal-body">

                    <div class="scroller" style="height:300px;overflow-y: auto;" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <input type="text" class="form-control search-drug" placeholder="Type and click other place in popup">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <span class="error"></span>
                                </p>
                            </div>
                        </div>
                        <div class="row drug-content">

                        </div>

                        <div class="row drug-settings" style="display: none">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover drug-settings-table" style="margin-top: 10px;">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Info</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <img width="20%" style="display:none" class="drug-loader" src="/assets/admin/img/loader-drugs.gif">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['class' => 'storage-save']) !!}
                    <button type="button" data-dismiss="modal" class="btn default">Close</button>
                    <button type="submit" class="btn green check-drug">Choose</button>
                    {!! Form::close([]) !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
    <div class="modal fade bs-modal-sm" id="watch" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body-watch">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div id="edit_view_drug" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><h4 class="modal-title">View Drug</h4></h4>
                </div>
                <div class="modal-body">

                    <div class="scroller" style="height:300px;overflow-y: auto" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="drug-name">

                                </h4>
                            </div>
                        </div>
                        <div class="row drug-content">

                        </div>

                        <div class="row drug-settings">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover drug-settings-view-table" style="margin-top: 10px;">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Info</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="order_message" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Message</h4>
                </div>
                {!! Form::open(['id' => 'order_send']) !!}
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class=" col-md-12 order-form-delivery-status-block">

                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12 order-form-status-block">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="order-message form-control" name="message" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn blue send-order-message-button">Send</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner">
            2014 &copy; Metronic by keenthemes.
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/admin/js/respond.min.js"></script>
<script src="/assets/admin/js/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/admin/js/jquery.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/assets/admin/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/assets/admin/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/admin/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/assets/admin/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/admin/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/assets/admin/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/assets/admin/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery.pulsate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<script src="/assets/admin/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/assets/admin/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="/assets/admin/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="/assets/admin/js/jquery-confirm.js"></script>

<script src="/assets/admin/js/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/js/layout.js" type="text/javascript"></script>
<script src="/assets/admin/js/demo.js" type="text/javascript"></script>
<script src="/assets/admin/js/index.js" type="text/javascript"></script>
<script src="/assets/admin/js/tasks.js" type="text/javascript"></script>
<script src="/assets/admin/js/table-managed.js"></script>
<script src="/assets/admin/js/admins.js"></script>
<script src="/assets/admin/js/drugs.js"></script>
<script src="/assets/admin/js/storage.js"></script>
<script src="/assets/admin/js/order.js"></script>
<script src="/assets/admin/js/message.js"></script>
<script src="/assets/admin/js/userOrder.js"></script>
<script src="/assets/admin/js/organization.js"></script>
<script src="/assets/admin/js/topRated.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBgAEkAL2phbCyMlJVqPYzhcG9cg4gIItU"
        type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    $(".ticket-table").dataTable();
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        Demo.init(); // init demo features
        Index.init();
        Index.initDashboardDaterange();
        Index.initJQVMAP(); // init index page's custom scripts
        Index.initCalendar(); // init index page's custom scripts
        Index.initCharts(); // init index page's custom scripts
        Index.initChat();
        Index.initMiniCharts();
        Tasks.initDashboardWidget();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>