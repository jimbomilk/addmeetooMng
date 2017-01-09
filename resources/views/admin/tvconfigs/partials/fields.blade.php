<div class="form-group">
    {!! Form::label('state', 'Status') !!}
    {!! Form::select('state', ['' => 'Select one','live'=>'Live' ,'pause'=>'Pause'],null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('timer', 'Timer') !!}
    {!! Form::number('screen_timer',null,['class'=>'form-control','placeholder'=>'Screen timer rollout'] ) !!}
</div>

<div class="form-group">
    {!! Form::label('location', 'Location') !!}
    {!! Form::select('location_id',(['0' => 'Select a Location'] + $locations),null,['class'=>'form-control']) !!}
</div>


<!-- TEMPLATE SCREEN -->

<!-- ACTIVITIES SELECTION -->
<div id="cf_source" class="panel panel-default">
    <div class="panel-heading">
        SCREEN TEMPLATE
    </div>
    <div class="panel-body source bg-success">
        <div id="XX" title="XX" class="col-lg-3" cf>
            <div class="draggable col-lg-12 bg-primary">
                <i class="fa fa-database"></i>
                XX
            </div>
        </div>

        <div id="YY" title="YY" class="col-lg-3" cf>
            <div class="draggable col-lg-12 bg-primary">
                <i class="fa fa-database"></i>
                YY
            </div>
        </div>

        <div id="ZZ" title="ZZ" class="col-lg-3" cf>
            <div class="draggable col-lg-12 bg-primary">
                <i class="fa fa-database"></i>
                ZZ
            </div>
        </div>
    </div>
</div>

<!-- PAGE LAYOUT -->
<div class="well text-center tools" data-id="PageLayout">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" title="btn_color">
            <i class="fa fa-table fa-2x"></i>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li style="height: 255px; width: 248px">
                <div class="SizeChooser">
                    <table><tbody><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr></tbody></table>
                    <div class="text-center">
                        <span class="colXrow">0</span> <span>x</span> <span class="colXrow">0</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <button type="button" class="btn btn-sm btn-default merge" title="btn_merge">
        <i class="fa fa-compress fa-2x"></i>
    </button>
    <button type="button" class="btn btn-sm btn-default btn-add-panel" title="btn_new_panel" style="display: none">
        <i class="fa fa-plus fa-2x"></i>
    </button>
</div>

<div class="row" id="PageLayout">

</div>

<!--K�lavuz panel-->
<div class="panel panel-default hidden">
    <div class="panel-heading tools">
        <span><button class="btn btn-xs contenteditable"><i class="fa fa-edit" style="cursor: pointer"></i></button> <span contenteditable="false">New panel</span></span>
        <div class="pull-right">
            <!--<a class="btn btn-xs btn-default move-cursor"><i class="fa fa-arrows"></i></a>-->
            <button type="button" class="btn btn-xs btn-default panel-toggle" title="btn_toggle">
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" title="btn_color">
                    <i class="fa fa-eye"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li data-color="default">
                        <button class="btn btn-block"> </button>
                    </li>
                    <li data-color="danger">
                        <button class="btn btn-danger btn-block"> </button>
                    </li>
                    <li data-color="success">
                        <button class="btn btn-success btn-block"> </button>
                    </li>
                    <li data-color="info">
                        <button class="btn btn-info btn-block"> </button>
                    </li>
                    <li data-color="warning">
                        <button class="btn btn-warning btn-block"> </button>
                    </li>
                    <li data-color="primary">
                        <button class="btn btn-primary btn-block"> </button>
                    </li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" title="btn_color">
                    <i class="fa fa-table"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li style="height: 255px; width: 248px">
                        <div class="SizeChooser">
                            <table><tbody><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr><tr><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td><td><button class="btn btn-xs"></button></td></tr></tbody></table>
                            <div class="text-center">
                                <span class="colXrow">0</span> <span>x</span> <span class="colXrow">0</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn btn-xs btn-default merge" title="btn_merge">
                <i class="fa fa-compress"></i>
            </button>

        </div>
    </div>
    <div class="panel-body">
        <table class="table-panel table table-bordered"></table>
    </div>
</div>