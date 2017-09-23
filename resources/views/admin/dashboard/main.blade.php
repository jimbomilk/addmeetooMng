@extends('admin.dashboard.layout')


@section ('dashboard_header')
    <section class="content-header">
        <h1>
            <i class="fa {{trans('design.main')}}"></i>
            {{trans('labels.main')}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="admin"><i class="fa fa-dashboard"></i> {{trans('labels.home')}}</a></li>
            <li class="active">{{trans('labels.main')}}</li>
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
        <section class="col-lg-12 connectedSortable">

            @include('admin.dashboard.partials.participationGraph')

            @include('admin.dashboard.partials.chat')

            @include('admin.dashboard.partials.advertisements')

        </section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->

    </div><!-- /.row (main row) -->
@endsection

@section('scripts')
    <script>
        var participationChart = <?php echo json_encode($participationChart) ?>;
        $('.target1').hide();

        $('.fastUpdate').on('click', function(e){
            console.log(e);
            var url = $(this).attr('data-url');
            var name = $(this).attr('data-name');
            var value = $(this).attr('data-value');
            var token = $("#_token").data("token");

            $.post(url, {name:name,value:value,_token:token} ,
                    function(response){
                        if(response.status === 500) {
                            alert('Server error. Check entered data.');
                        } else {
                            location.reload();
                            // return "Error.";
                        }
                    }, "json");
        });
    </script>
@endsection