<div class="form-group">
    @include("admin.common.input_datetime",array('var'=>'startdate'))
    @include("admin.common.input_datetime",array('var'=>'enddate'))
    @include("admin.common.input_hidden",array('var'=>'latitude'))
    @include("admin.common.input_hidden",array('var'=>'longitude'))
</div>


@include("admin.common.input_text",array('var'=>'address'))
@include("admin.common.input_number",array('var'=>'radio'))
<div style="height:100%;width: 100%;margin-bottom: 20px">
    {!!  $map['html'] !!}
</div>


@section('scripts')
    {!! $map['js'] !!}
@endsection