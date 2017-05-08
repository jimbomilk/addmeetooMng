<div class="form-group">
    @include("admin.common.input_text",array('var'=>'name'))
    @include("admin.common.input_select",array('var'=>'adscategory_id','col'=>$adscategories))

    <h3>Gran formato<small>(Recomendado: 1800x600)</small></h3>
    <hr class="separator">
    @include("admin.common.input_file",array('var'=>'imagebig','width'=>400,'height'=>200))
    @include("admin.common.input_text",array('var'=>'textbig1'))
    @include("admin.common.input_text",array('var'=>'textbig2'))

    <h3>Pequeño formato<small>(Recomendado: 300x300)</small></h3>
    <hr class="separator">
    @include("admin.common.input_file",array('var'=>'imagesmall','width'=>200,'height'=>100))
    @include("admin.common.input_text",array('var'=>'textsmall1'))
    @include("admin.common.input_text",array('var'=>'textsmall2'))



</div>

