<div class="form-group">

    @include("admin.common.input_select",array('var'=>'activity_id','col'=>$activities))
    @include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))
    @include("admin.common.input_text",array('var'=>'name'))
    @include("admin.common.input_text",array('var'=>'description'))
    @include("admin.common.input_check",array('var'=>'auto','default'=>1))
    @include("admin.common.input_time",array('var'=>'starttime'))
    @include("admin.common.input_number",array('var'=>'duration'))
    @include("admin.common.input_number",array('var'=>'deadline'))
    @include("admin.common.input_check",array('var'=>'participation_status','default'=>1))
    @include("admin.common.input_number",array('var'=>'selection'))
    @include("admin.common.input_select",array('var'=>'progression_type','col'=>$progression))
    @include("admin.common.input_check",array('var'=>'multiscreen','default'=>0))

</div>
