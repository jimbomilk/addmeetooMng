<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get('label.users.name')}}</th>
        <th>{{Lang::get('label.users.email')}}</th>
        <th>{{Lang::get('label.users.edit')}}</th>
        <th>{{Lang::get('label.users.profile')}}</th>
        <th></th>

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