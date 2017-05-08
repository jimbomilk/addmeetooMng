<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        @if($login_user->type=='admin')
            <th>{{Lang::get('label.locations.name')}}</th>
        @endif
        <th>{{Lang::get('label.gameboards.name')}}</th>
        <th>{{Lang::get('label.gameboards.starttime')}}</th>
        <th>{{Lang::get('label.gameboards.duration')}}</th>
        <th>{{Lang::get('label.gameboards.status')}}</th>

        <th>{{Lang::get('label.gameboards.options')}}</th>
        <th></th>
        <th></th>
            <th></th>
    </tr>
    @foreach($set as $game)
        <tr data-id="{{$game->id}}">
            @if($login_user->type=='admin')
                <td>{{$game->location->name}}</td>
            @endif
            <td>{{$game->name}}</td>
            <td>{{$game->localStarttime}}</td>
            <td>{{$game->duration}} min</td>
            <td>
               <div class="btn-group">
                   <button type="button" class="btn btn-{{$colours[$game->status]}} dropdown-toggle" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                            {{$statuses[$game->status]}}
                       <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($statuses as $key=>$status)
                                <li>
                                   <a href="#" class="fastUpdate" data-url="{{route('gameboard_fast',['id'=>$game->id])}}" data-value="{{$key}}" data-name="status"> {{$status}} </a>
                                </li>
                        @endforeach
                    </ul>
                </div>
            </td>


            <td>
                @if(!$game->auto)
                    @include("admin.common.btn_edit",array('var'=>$game))
                @endif
            </td>

            <td>
                @include("admin.common.btn_show",array('var'=>$game))
            </td>

            <td>
                @include("admin.common.btn_other",array('route'=> 'gameboards_preview','var'=>$game,'label'=>'preview'))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$game))
            </td>


        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>

@section('scripts')
    <script>

        $('.fastUpdate').on('click', function(e){
            console.log(e);
            var url = $(this).attr('data-url');
            var name = $(this).attr('data-name');
            var value = $(this).attr('data-value');
            var token = $("#_token").data("token");

            $.post(url, {name:name,value:value,_token:token} ,
                    function(response){
                        if(response.status === 500) {
                            alert('Server error. Check entered data.');
                        } else {
                            location.reload();
                            // return "Error.";
                        }
                    }, "json");
        });


    </script>
@endsection