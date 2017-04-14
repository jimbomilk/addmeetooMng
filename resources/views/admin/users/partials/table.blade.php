<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    @foreach($set as $user)
        <tr data-id="{{$user->id}}">
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$user))
            </td>

            <td>
                @include("admin.common.btn_show",array('var'=>$user))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$user))
            </td>
        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>