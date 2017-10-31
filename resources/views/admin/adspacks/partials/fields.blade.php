<div class="form-group">
    @if(isset($now))
        @include("admin.common.input_datetime",array('var'=>'startdate','default'=>$now))
    @else
        @include("admin.common.input_datetime",array('var'=>'startdate'))
    @endif

    @if(isset($next))
        @include("admin.common.input_datetime",array('var'=>'enddate','default'=>$next))
    @else
        @include("admin.common.input_datetime",array('var'=>'enddate'))
    @endif
@include("admin.common.input_hidden",array('var'=>'latitude'))
@include("admin.common.input_hidden",array('var'=>'longitude'))

@include("admin.common.input_check",array('var'=>'toscreen','default'=>1))
@include("admin.common.input_check",array('var'=>'tomobile','default'=>1))
</div>

@if(isset($dir))

    @include("admin.common.input_text",array('var'=>'address','val'=>$dir))
@else
    @include("admin.common.input_text",array('var'=>'address'))
@endif

@include("admin.common.input_number",array('var'=>'radio','val'=>10))
<div style="height:100%;width: 100%;margin-bottom: 20px">
{!!  $map['html'] !!}
</div>


@section('scripts')
{!! $map['js'] !!}
@endsection