<h3>Lugar de la notificación</h3>
<hr class="separator">
@include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))
<h3>Título y descripción</h3>
<hr class="separator">
@include("admin.common.input_text",array('var'=>'title'))
@include("admin.common.input_text",array('var'=>'text'))
<h3>¿A quién se envía? (Participantes de los juegos)</h3>
<hr class="separator">
@include("admin.common.input_select",array('var'=>'who','col'=>$games,'nolabel'=>1))

