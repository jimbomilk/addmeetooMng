@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{Lang::get('label.login')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('auth/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{Lang::get('label.login.email')}}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="jmgarciacarrasco@gmail.com">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{Lang::get('label.login.password')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{Lang::get('label.login.recuerda')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> {{Lang::get('label.login.login')}}
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">{{Lang::get('label.login.forgot')}}</a>
                            </div>
                        </div>

                        <p class="or-social">{{Lang::get('label.login.social_login')}}</p>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-lg waves-effect waves-light btn-block google">Google+</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
