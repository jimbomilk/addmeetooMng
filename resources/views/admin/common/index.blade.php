@extends('admin.dashboard.layout')


@section ('dashboard_header')
    @include("admin.common.partials.header")
@endsection

@section('dashboard_content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12" style="padding-right: 60px">
                <div class="panel panel-default">
                    <div class="panel-heading">Total {{ trans('labels.'.$name)}}: <span class="panel-heading-total">{{ is_array($set)? count($set): $set->total() }}</span> </div>

                    @if (Session::has('message'))
                        <p class="alert alert-success">
                            {{ Session::get('message') }}
                        </p>
                    @endif
                    <div class="panel-body">

                        @if (isset($searchable))
                            {!! Form::model(Request::all(), ['route' => "$login_user->type.$name.index", 'method'=>'GET', 'class' => 'navbar-form navbar-left pull-right', 'role'=>'search']) !!}
                            <div class="form-group">
                                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder'=>'Search']) !!}
                            </div>
                            <button type="submit" class="btn btn-default">{{trans('labels.search')}}</button>
                            {!! Form::close() !!}
                        @endif

                        @if (isset($withlocations))
                        {!! Form::model(Request::all(), ['route' => "$login_user->type.$name.index", 'method'=>'GET', 'class' => 'navbar-form navbar-left pull-right', 'role'=>'location']) !!}
                                @include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))
                                @include("admin.common.input_hidden",array('var'=>'monthly','val'=>isset($monthly)?$monthly:0))
                                <button type="submit" class="btn btn-default">{{trans('labels.changelocation')}}</button>

                        {!! Form::close() !!}
                        @endif

                        @if(!isset($hide_new) || !$hide_new)
                        <p>
                            <a class="btn btn-info" href="{{ route("$login_user->type.$name.create") }}" role="button">
                                {{trans('labels.new')}} {{trans('label.'.$name)}}
                                </a>
                        </p>
                        @endif

                        @if (isset($saveall)&&$saveall)
                            {!! Form::model(Request::all(), ['route' => "$login_user->type.$name.saveall", 'method'=>'POST', 'role'=>'saveall']) !!}
                        @endif

                        @include("admin.$name.partials.table")

                        @if (isset($saveall)&&$saveall)
                            <button type="submit" class="btn btn-info pull-right" style="margin-right: 10px">{{trans('labels.saveall')}}</button>
                            {!! Form::close() !!}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => ["admin.$name.destroy",':ELEMENT_ID'], 'method' => 'DELETE', 'id' =>'form-delete' ]) !!}
    
    {!! Form::close() !!}
@endsection


