<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('assets/css/admin/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/">
                {{--<img src="../assets/layouts/layout/img/logo.png" alt="logo" class="logo-default"/>--}}

                后台管理系统
            </a>
            <div class="menu-toggler sidebar-toggler hide">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN USER LOGIN DROPDOWN -->

                @if(auth()->guard('admin')->user())
                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username"> {{ auth()->guard('admin')->user()->name }} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="/logout" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> 退出 </a>

                                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown dropdown-user"><a href="/login" class="dropdown-toggle">
                            <span class="username"> Login </span>
                            <i class="fa fa-sign-in"></i>
                        </a></li>
            @endif
            <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->

{{--<div class="clearfix"></div>--}}
<div class="page-container">
@if(auth()->guard('admin')->user())
    @include('admin.components.page-sidebar')
@endif
    <!-- BEGIN PAGE CONTENT -->
        <div class="page-content-wrapper" id="page_content_container">
            <!-- BEGIN CONTENT -->
            <div class="page-content" id="page_content">

                {{-- BEGIN FLASH MESSAGE --}}
                @if(session('flash_error_message'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        {{ session('flash_error_message') }}
                    </div>
                @elseif(session('flash_success_message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        {{ session('flash_success_message') }}
                    </div>
                @endif
                {{-- END FLASH MESSAGE --}}

                {{-- VIEW CONTENT --}}
                @yield('content')

            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END PAGE CONTENT -->
</div>

<!-- Scripts -->
<script src="{{ elixir('assets/js/admin/app.js') }}"></script>
<script>
    $(function () {
        // init app
        app.init();
    });
    // 全局 ajax 表单提交使用的 csrf token
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken}
    });
</script>
</body>
</html>
