<div class="form-group">
    @include("admin.common.input_text",array('var'=>'name'))
    @include("admin.common.input_select",array('var'=>'adscategory_id','col'=>$adscategories))
    @include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))

    <h3>Gran formato<small>(Recomendado: 1800x600, jpg o png)</small></h3>
    <hr class="separator">
    <h4>Si quieres puedes diseñar tu anuncio <a href="https://desygner.com/" target="_blank">aquí</a></h4>
    <div class="form-group">
    @include("admin.common.input_file",array('var'=>'imagebig','width'=>400,'height'=>200))
    </div>

    <h3>Pequeño formato<small>(Recomendado: 300x200 jpg o png)</small></h3>
    <hr class="separator">
    @include("admin.common.input_file",array('var'=>'imagesmall','width'=>200,'height'=>100))

</div>

