@extends('admin.dashboard.layout')


@section ('dashboard_header')
    <section class="content-header">
        <h1>
            <i class='{{trans("design.".$name)}}'></i>
            {{ trans('labels.'.$name)}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="/{{$login_user->type}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">{{ $name }}</li>
        </ol>
    </section>
@endsection

@section('dashboard_content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create new {{ trans('label.'.$name)}} </div>

                    <div class="panel-body">

                        @include('admin.common.partials.msgErrors')


                        {!! Form::open(array('route' => "$login_user->type.$name.store", 'method' => 'POST' )) !!}
                            @include("admin.$name.partials.fields")
                            <button type="submit" class="btn btn-default">Create</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
