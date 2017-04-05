<table class="table table-striped">
    <tr>
        @if($login_user->type=='admin')
            <th>Location</th>
            <th>Owner</th>
        @endif
        <th>Name</th>
        <th>Start Time</th>
        <th>Duration</th>
        <th>Status</th>

        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $game)
        <tr data-id="{{$game->id}}">
            @if($login_user->type=='admin')
                <td>{{$game->location->name}}</td>
                <td>{{$game->location->owner->name}}</td>
            @endif
            <td>{{$game->name}}</td>
            <td>{{$game->getLocalStarttime()}}</td>
            <td>{{$game->duration}} min</td>
            <td>
               <button type="button" class="btn btn-{{$colours[$game->status]}} "  aria-haspopup="true" aria-expanded="false">
                        {{$statuses[$game->status]}}
                </button>
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
                @include("admin.common.btn_delete",array('var'=>$game))
            </td>


        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>