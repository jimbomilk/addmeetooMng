<div class="form-group">
    @if(isset($element))
        {!! HTML::image($login_user->type.'/images/'.$element->$var, 'location photo',array( 'width' => 70, 'height' => 70 )) !!}
    @endif
</div>

<div class="form-group">
    {!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
    {!! Form::file($var, null,array('class'=>'file')) !!}
</div>
<br>