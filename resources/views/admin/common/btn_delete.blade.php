{!! Form::open(['method' => 'DELETE','route' => [$login_user->type.'.' . $name . '.destroy', $var],'style'=>'display:inline']) !!}
{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}