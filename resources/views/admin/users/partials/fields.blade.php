@include("admin.common.input_text",array('var'=>'name'))
@include("admin.common.input_text",array('var'=>'email'))
@include("admin.common.input_password",array('var'=>'password'))
@include("admin.common.input_password",array('var'=>'password2'))
@include("admin.common.input_select",array('var'=>'type','col'=>$types))
@include("admin.common.input_check",array('var'=>'gamemanager'))
@include("admin.common.input_check",array('var'=>'incidencemanager'))
