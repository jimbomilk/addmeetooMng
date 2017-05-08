<div class="form-group">
    @if(isset($element))
        {!! HTML::image($element->$var, $var,array('id'=>$var.'-image-tag', 'width' => $width, 'height' => $height )) !!}
    @endif
</div>

<div class="form-group">
    {!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
    {!! Form::file($var, null,array('class'=>'file')) !!}
</div>
<br>

@section('scripts')
    <script type="text/javascript">
        $('#{{$var}}').change(function(){
            readURL(this,'#{{$var}}-image-tag');
        });
    </script>
@append