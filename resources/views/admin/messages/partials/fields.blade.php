<h3>Inicio y fin de publicación del mensaje</h3>
<hr class="separator">
@include("admin.common.input_datetime",array('var'=>'start'))
@include("admin.common.input_datetime",array('var'=>'end'))
<h3>Categoría</h3>
<hr class="separator">
@include("admin.common.input_select",array('var'=>'type','col'=>$types))
<h3>Lugar de publicación</h3>
<hr class="separator">
@include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))
<h3>Título y descripción</h3>
<hr class="separator">
@include("admin.common.input_text",array('var'=>'stext'))
@include("admin.common.input_textarea",array('var'=>'ltext'))
<h3>Imagenes</h3>
<hr class="separator">
@include("admin.common.input_file",array('var'=>'image','width'=>360,'height'=>360))
@include("admin.common.input_file",array('var'=>'imagebig','width'=>600,'height'=>200))
