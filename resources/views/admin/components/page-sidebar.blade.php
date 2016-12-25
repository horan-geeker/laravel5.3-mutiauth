<?php

$pathname = explode($_SERVER['HTTP_HOST'], url()->current())[1];

?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu">
            <li class="{{ $pathname == '/admin' ? 'active' : '' }}">
                <a href="/admin"
                   data-pjax
                   data-container="#page_content_container"
                >
                    <i class="fa fa-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>

            @foreach(auth('admin')->user()->permissions->groupBy('title') as $title=>$submodule)
                <li class="heading">
                    <h3 class="uppercase">{{ $title }}</h3>
                </li>
                @foreach($submodule as $module)
                    <li>
                        <a href="{{ $module->uri }}"
                           data-pjax
                           data-container="#page_content_container"
                        >
                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                            <span class="title">{{ $module->description }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->