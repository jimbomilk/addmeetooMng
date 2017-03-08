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
            <td>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">Edit</a> |
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>