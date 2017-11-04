{!! Form::open(['method' => 'POST','route' => [$route, $var],'style'=>'display:inline']) !!}
@if (isset($style))
    {!! Form::submit($label, ['class' => 'btn '.$style]) !!}
@else
    {!! Form::submit($label,['class' => 'btn btn-info']) !!}
@endif
{!! Form::close() !!}