
@extends('app')

@section('content')
<div class="wrapper">
    @include('admin.dashboard.header')
    @include('admin.dashboard.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @yield('dashboard_header')

        <div>&nbsp;</div>
        <!-- Main content -->

        @yield('dashboard_content')


    </div><!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2015-2016<a href="http://addmeetoo.com">Addmeetoo Develpments</a>.</strong> All rights reserved.
    </footer>
</div><!-- ./wrapper -->
@endsection