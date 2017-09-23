
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th style="text-align: center">{{Lang::get('label.gameboard_options.order')}}</th>
        <th style="text-align: center">{{Lang::get('label.gameboard_options.image')}}</th>
        <th>{{Lang::get('label.gameboard_options.description')}}</th>
        @if($game->type=='bet')
        <th>{{Lang::get('label.gameboard_options.results')}}</th>
        @endif
        <th></th>
        <th></th>

    </tr>
    @foreach($set as $gameboard_option)
        <tr data-id="{{$gameboard_option->id}}">
            <td style="text-align: center">{{$gameboard_option->order}}</td>
            <td style="text-align: center">{!! HTML::image($gameboard_option->image, 'photo',array( 'width' => 50, 'height' => 50 )) !!}</td>
            <td>{{$gameboard_option->description}}</td>
            @if($game->type=='bet'||$game->type=='game')
            <td><a href="#" class="fastEdit" data-type="number" data-column="result" data-url="{{route($login_user->type.'.gameboard_option_fast',['id'=>$gameboard_option->id])}}" data-pk="{{$gameboard_option->id}}" data-name="result"> {{$gameboard_option->result}} </a> </td>
            @endif
            <td>
                @if(!$gameboard_option->gameboard->auto)
                    @include("admin.common.btn_edit",array('var'=>$gameboard_option))
                @endif
            </td>

            <td>
                @if(!$gameboard_option->gameboard->auto)
                    @include("admin.common.btn_delete",array('var'=>$gameboard_option))
                @endif
            </td>

        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
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