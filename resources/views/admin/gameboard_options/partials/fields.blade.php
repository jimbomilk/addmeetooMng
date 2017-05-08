@include("admin.common.input_file",array('var'=>'image','width'=>70,'height'=>70))
@include("admin.common.input_number",array('var'=>'order'))
@include("admin.common.input_text",array('var'=>'description'))
@if (!isset($creation) || !$creation)
@include("admin.common.input_number",array('var'=>'result'))
@endif