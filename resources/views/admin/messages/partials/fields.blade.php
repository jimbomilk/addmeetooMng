@include("admin.common.input_datetime",array('var'=>'start'))
@include("admin.common.input_datetime",array('var'=>'end'))
@include("admin.common.input_select",array('var'=>'type','col'=>$types))
@include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))
@include("admin.common.input_text",array('var'=>'stext'))

@include("admin.common.input_file",array('var'=>'image','width'=>360,'height'=>360))
