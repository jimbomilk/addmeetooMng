{!! Form::open(['method' => 'POST','route' => [$route, $var],'style'=>'display:inline']) !!}
{!! Form::submit($label, ['class' => 'btn '.$style]) !!}
{!! Form::close() !!}