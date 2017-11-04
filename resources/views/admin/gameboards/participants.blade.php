@extends('admin.dashboard.layout')
@section ('dashboard_header')
    @include("admin.common.partials.header")
@endsection

@section('dashboard_content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12" style="padding-right: 60px">
                <div class="panel panel-default">

                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="panel panel-default">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="nav-tabs-custom">
                            <!-- Tabs within a box -->
                            <ul class="nav nav-tabs pull-right">
                                <li class="pull-left header"><i class="fa fa-inbox"></i> Resultados</li>
                            </ul>
                            <div class="tab-content no-padding">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="results-chart" style="position: relative; height: 300px;width: 300px;margin: auto"></div>

                            </div>
                        </div><!-- /.nav-tabs-custom -->

                    </div>
                    <div class="nav-tabs-custom">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs pull-right">
                            <li class="pull-left header"><i class="fa fa-inbox"></i> Participacion</li>
                        </ul>
                        <div class="tab-content no-padding">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>

                        </div>
                    </div><!-- /.nav-tabs-custom -->
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var participationChart = <?php echo json_encode($participationChart)?>;
        var resultChart = <?php echo json_encode($resultChart)?>;
    </script>
@endsection