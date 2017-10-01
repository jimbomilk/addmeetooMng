
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th style="text-align: center">{{Lang::get('label.gameboard_options.order')}}</th>
        <th style="text-align: center">{{Lang::get('label.gameboard_options.image')}}</th>
        <th>{{Lang::get('label.gameboard_options.description')}}</th>
        @if(($game->type=='bet'||$game->type=='game')&&$saveall)
        <th>{{Lang::get('label.gameboard_options.results')}}</th>
        @endif
        @if(!$game->auto && $game->status == \App\Status::DISABLED)
        <th></th>
        <th></th>
        @endif
</tr>
@include("admin.common.input_hidden",array('var'=>'gameid','val'=>$game->id))
@foreach($set as $gameboard_option)
<tr data-id="{{$gameboard_option->id}}">
    <td style="text-align: center">{{$gameboard_option->order}}</td>
    <td style="text-align: center">{!! HTML::image($gameboard_option->image, 'photo',array( 'width' => 50, 'height' => 50 )) !!}</td>
    <td>{{$gameboard_option->description}}</td>

    @if(($game->type=='bet'||$game->type=='game')&&$saveall)
    <td>
        @if(isset($game->selection)&&($game->selection==1))
            @include("admin.common.input_select",array('var'=>$gameboard_option->id,'col'=>[0=>'INCORRECTO',1=>'CORRECTO'],'val'=>$gameboard_option->result,'nolabel'=>1))
        @else
            @include("admin.common.input_number",array('var'=>$gameboard_option->id,'val'=>$gameboard_option->result,'nolabel'=>1))
        @endif
    </td>
    @endif
    @if(!$game->auto && $game->status == \App\Status::DISABLED)
    <td>
        @include("admin.common.btn_edit",array('var'=>$gameboard_option))
    </td>
    <td>
        @include("admin.common.btn_delete",array('var'=>$gameboard_option))
    </td>
    @endif

</tr>
@endforeach
<div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>
</table>

@section('scripts')
<script type= text/javascript>
$(document).ready(function() {
    $.fn.editable.defaults.mode = 'inline';
    //make username editable
    $('.fastEdit').editable({
        params: function(params) {
            // add additional params from data-attributes of trigger element
            params._token = $("#_token").data("token");
            params.name = $(this).editable().data('name');
            return params;
        },
        error: function(response, newValue) {
            if(response.status === 500) {
                return 'Server error. Check entered data.';
            } else {
                return response.responseText;
                // return "Error.";
            }
        }
    });
});
</script>
@endsection