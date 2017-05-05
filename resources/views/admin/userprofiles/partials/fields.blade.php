<div class="form-group">

    @include("admin.common.input_file",array('var'=>'avatar'))
    @include("admin.common.input_select",array('var'=>'gender','col'=>$genders))
    @include("admin.common.input_number",array('var'=>'points'))
    @include("admin.common.input_number",array('var'=>'rank'))
    @include("admin.common.input_text",array('var'=>'bio'))
    @include("admin.common.input_number",array('var'=>'phone'))
</div>

