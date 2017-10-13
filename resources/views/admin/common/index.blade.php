@extends('admin.dashboard.layout')


@section ('dashboard_header')
    <section class="content-header">
        <h1>
            <i class="fa {{trans('design.'.$name)}}"></i>
            <strong>{{ trans('labels.'.$name) }}</strong>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/{{$login_user->type}}"><i class="fa fa-dashboard"></i> {{trans('labels.home')}}</a></li>
            <li class="active">{{  trans('labels.'.$name)}}</li>
        </ol>
    </section>
@endsection

@section('dashboard_content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Total {{ trans('labels.'.$name)}}: <span class="panel-heading-total">{{ $set->total() }}</span> </div>

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


