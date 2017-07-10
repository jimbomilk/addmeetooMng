{!! Form::open(['method' => 'DELETE','route' => [$login_user->type.'.' . $name . '.destroy', $var],'style'=>'display:inline']) !!}
{!! Form::submit(trans('labels.delete'), ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}