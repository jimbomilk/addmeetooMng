<div class="form-group">

    <h3>Actividad padre <small>Todo juego deriva de una actividad principal</small></h3>
    <hr class="separator">
    @include("admin.common.input_check",array('var'=>'auto','default'=>1))
    @include("admin.common.input_select",array('var'=>'activity_id','col'=>$activities))

    <h3>Descripción y localización</h3>
    <hr class="separator">
    @include("admin.common.input_select",array('var'=>'location_id','col'=>$locations))
    @include("admin.common.input_text",array('var'=>'name'))
    @include("admin.common.input_text",array('var'=>'description'))

    <div id="diferida">
    <h3>Ejecución <small>Si deseas que sea gestionado por la actividad padre, marcar gestión diferida</small></h3>
    <hr class="separator">
    @include("admin.common.input_time",array('var'=>'starttime'))
    @include("admin.common.input_number",array('var'=>'duration'))
    @include("admin.common.input_number",array('var'=>'selection'))
    </div>

    <h3>Participación y fin del juego</h3>
    <hr class="separator">
    @include("admin.common.input_datetime",array('var'=>'deadline'))
    @include("admin.common.input_datetime",array('var'=>'endgame'))

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
