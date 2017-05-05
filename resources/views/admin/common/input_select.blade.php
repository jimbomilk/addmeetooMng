<div class="form-group">
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
{!! Form::select($var, $col,null, ['id' => $var, 'class' => 'form-control']) !!}
</div>