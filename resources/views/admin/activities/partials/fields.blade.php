<div class="form-group">

    @include("admin.common.input_text",array('var'=>'name'))
    @include("admin.common.input_text",array('var'=>'description'))
    @include("admin.common.input_time",array('var'=>'starttime'))
    @include("admin.common.input_number",array('var'=>'duration'))
    @include("admin.common.input_number",array('var'=>'deadline'))
    @include("admin.common.input_select",array('var'=>'type','col'=>$types))
    @include("admin.common.input_select",array('var'=>'category','col'=>$categories))
    @include("admin.common.input_check",array('var'=>'head2head','default'=>1))
    @include("admin.common.input_number",array('var'=>'selection'))
    @include("admin.common.input_number",array('var'=>'reward_participation'))
    @include("admin.common.input_check",array('var'=>'reward','default'=>1))
    @include("admin.common.input_number",array('var'=>'reward_first'))
    @include("admin.common.input_number",array('var'=>'reward_second'))
    @include("admin.common.input_number",array('var'=>'reward_third'))

</div>

