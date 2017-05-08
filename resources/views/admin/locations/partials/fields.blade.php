@include("admin.common.input_file",array('var'=>'logo','width'=>300,'height'=>150))
@include("admin.common.input_select",array('var'=>'category','col'=>$categories))
@include("admin.common.input_select",array('var'=>'owner_id','col'=>$owners))
@include("admin.common.input_text",array('var'=>'name'))
@include("admin.common.input_text",array('var'=>'phone'))
@include("admin.common.input_hidden",array('var'=>'latitude'))
@include("admin.common.input_hidden",array('var'=>'longitude'))
@include("admin.common.input_select",array('var'=>'countries_id','col'=>$countries))
@include("admin.common.input_text",array('var'=>'timezone'))
@include("admin.common.input_text",array('var'=>'website'))

@include("admin.common.input_text",array('var'=>'address'))
<div style="height:100%;width: 100%">
    {!!  $map['html'] !!}
</div>


@section('scripts')
    {!! $map['js'] !!}
@endsection