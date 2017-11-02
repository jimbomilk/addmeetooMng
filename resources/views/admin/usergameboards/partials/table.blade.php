<table class="table table-striped">
    <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>Id</th>
        <th>Points</th>
        @if ($login_user->is('admin'))
        <th></th>
        @endif
    </tr>
    @foreach($set as $indexKey => $usergameboard)
        <tr data-id="{{$usergameboard->id}}">
            <td>{{(($set->currentPage()-1) * $set->perPage()) + $indexKey+1}}</td>
            <td>{{$usergameboard->user->name}}</td>
            <td>{{$usergameboard->user->id}}</td>
            <td>{{$usergameboard->points}}</td>
            @if ($login_user->is('admin'))
            <td>
                @include("admin.common.btn_edit",array('var'=>$usergameboard))
                @include("admin.common.btn_delete",array('var'=>$usergameboard))
            </td>
            @endif
        </tr>
    @endforeach
    <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>

</table>