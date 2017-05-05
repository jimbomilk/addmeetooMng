<table class="table table-striped">
    <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>Points</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $indexKey => $usergameboard)
        <tr data-id="{{$usergameboard->id}}">
            <td>{{$indexKey+1}}</td>
            <td>{{$usergameboard->user->name}}</td>
            <td>{{$usergameboard->points}}</td>
            <td>
                @include("admin.common.btn_edit",array('var'=>$usergameboard))
            </td>
            <td>
                @include("admin.common.btn_delete",array('var'=>$usergameboard))
            </td>
        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>