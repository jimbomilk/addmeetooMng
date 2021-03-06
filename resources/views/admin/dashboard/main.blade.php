@extends('admin.dashboard.layout')


@section ('dashboard_header')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
@endsection

@section('dashboard_content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        @include ('admin.dashboard.partials.boxes')
    </div><!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

            @include('admin.dashboard.partials.participationGraph')

            @include('admin.dashboard.partials.chat')

            @include('admin.dashboard.partials.advertisements')

        </section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

            @include ('admin.dashboard.partials.visitors')

            @include('admin.dashboard.partials.auctionChart')

            @include('admin.dashboard.partials.votingChart')

        </section><!-- right col -->
    </div><!-- /.row (main row) -->
@endsection
