@extends('admin.dashboard.layout')


@section ('dashboard_header')
    <section class="content-header">
        <h1>
            <i class="fa {{trans('design.'.$name)}}"></i>
            <small>{{ ucfirst($name) }}</small>
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
                    <div class="panel-heading">Total {{$name}}: <span class="panel-heading-total">{{ $set->total() }}</span> </div>

                    @if (Session::has('message'))
                        <p class="alert alert-success">
                            {{ Session::get('message') }}
                        </p>
                    @endif
                    <div class="panel-body">


                        {!! Form::model(Request::all(), ['route' => "admin.$name.index", 'method'=>'GET', 'class' => 'navbar-form navbar-left pull-right', 'role'=>'search']) !!}
                            <div class="form-group">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Search']) !!}
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        {!! Form::close() !!}

                        @if(!isset($hide_new) || !$hide_new)
                        <p>
                            <a class="btn btn-info" href="{{ route("$login_user->type.$name.create") }}" role="button">
                                New
                            </a>
                        </p>
                        @endif

                        @include("admin.$name.partials.table")




                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => ["admin.$name.destroy",':ELEMENT_ID'], 'method' => 'DELETE', 'id' =>'form-delete' ]) !!}
    
    {!! Form::close() !!}
@endsection


