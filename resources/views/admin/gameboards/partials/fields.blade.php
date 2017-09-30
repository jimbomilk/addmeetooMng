<div class="form-group">

    <h3>Actividad <small>¿Qué tipo de juego deseas poner en marcha?</small></h3>
    <hr class="separator">
    @include("admin.common.input_select",array('var'=>'activity_id','col'=>$activities))
    @include("admin.common.input_number",array('var'=>'selection'))


    <h3>Descripción y localización</h3>
    <hr class="separator">
    @include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))
    @include("admin.common.input_text",array('var'=>'name'))
    @include("admin.common.input_text",array('var'=>'description'))


    <h3>Inicio y fin del juego</h3>
    <hr class="separator">
    @include("admin.common.input_datetime",array('var'=>'startgame'))
    @include("admin.common.input_datetime",array('var'=>'deadline'))
    @include("admin.common.input_datetime",array('var'=>'endgame'))

    <h3>Imagen(opcional)</h3>
    <hr class="separator">
    @include("admin.common.input_file",array('var'=>'image','width'=>300,'height'=>200))

</div>

@section('scripts')
    <script>

        $(document).ready(function(){

            // Selection linked with head2head
            $('#diferida').toggle(!$('#auto').is(':checked'));
            $('#auto').bind('change',function(){
                $('#diferida').toggle(!$(this).is(':checked'));
            });


            $('#activity_id').change(function() {


            });

        });
    </script>
@endsection
