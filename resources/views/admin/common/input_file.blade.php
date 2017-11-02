<div class="form-group">
    @if(isset($element))
        {!! HTML::image($element->$var, $var,array('id'=>$var.'-image-tag', 'width' => $width, 'height' => $height,'float'=>'left')) !!}
        <a class="btn-remove" id="{{$var}}-remove" style="position:absolute;float:left;display: none"><i class="btn btn-primary">x</i></a>
    @endif
</div>

<div class="form-group">
    {!! Form::hidden($var.'file', null, array('name'=>$var,'id'=>$var.'file')) !!}
    {!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
    <span>{!! Form::file($var, null) !!}</span>

</div>
<br>

@section('scripts')
    <script type="text/javascript">
        $('#{{$var}}').change(function(){
            readURL(this,'#{{$var}}-image-tag');
            $('#{{$var}}-remove').show();
        });

        $('#{{$var}}-image-tag').load(function(){
            s=$('#{{$var}}-image-tag').attr('src');
            if (s != "")
                $('#{{$var}}-remove').show();

            $("#{{$var}}file").val(s);
        });

        $('#{{$var}}-remove').click(function(){
            $('#{{$var}}-image-tag').attr('src', '');
            $("#{{$var}}file").val("");
            $('#{{$var}}-remove').hide();
        })
    </script>
@append