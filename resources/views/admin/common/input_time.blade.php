<div class="form-group">
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
{!! Form::time($var, null, array('class'=>'form-control','placeholder'=>Lang::get('label_desc.'.$name.'.'.$var))) !!}
</div>