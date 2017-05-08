<div class="form-group">

    <h3>Descripción</h3>
    <hr class="separator">
    @include("admin.common.input_text",array('var'=>'name'))
    @include("admin.common.input_text",array('var'=>'description'))

    <h3>Características</h3>
    <hr class="separator">
    @include("admin.common.input_select",array('var'=>'type','col'=>$types))
    @include("admin.common.input_select",array('var'=>'category','col'=>$categories))
    @include("admin.common.input_check",array('var'=>'head2head','default'=>1))
    @include("admin.common.input_number",array('var'=>'selection'))

    <h3>Puntuaciones</h3>
    <hr class="separator">
    @include("admin.common.input_number",array('var'=>'reward_participation'))
    @include("admin.common.input_check",array('var'=>'reward','default'=>1))
    @include("admin.common.input_number",array('var'=>'reward_first'))
    @include("admin.common.input_number",array('var'=>'reward_second'))
    @include("admin.common.input_number",array('var'=>'reward_third'))

</div>

@section('scripts')
    <script>

        $(document).ready(function(){

            // Selection linked with head2head
            $('#selection').toggle(!$('#head2head').is(':checked'));
            $('#head2head').bind('change',function(){
                $('#selection').toggle(!$(this).is(':checked'));
            });

            // Rewards linked with rewards checksbox
            $('#reward_first').toggle($('#reward').is(':checked'));
            $('#reward_second').toggle($('#reward').is(':checked'));
            $('#reward_third').toggle($('#reward').is(':checked'));

            $('#reward').bind('change',function(){
                $('#reward_first').toggle($(this).is(':checked'));
                $('#reward_second').toggle($(this).is(':checked'));
                $('#reward_third').toggle($(this).is(':checked'));
            });

        });
    </script>
@endsection