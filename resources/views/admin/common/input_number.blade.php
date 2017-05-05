<div class="form-group" id={{$var}}>
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
{!! Form::number($var, null, array('class'=>'form-control','placeholder'=>Lang::get('label_desc.'.$name.'.'.$var))) !!}
</div>