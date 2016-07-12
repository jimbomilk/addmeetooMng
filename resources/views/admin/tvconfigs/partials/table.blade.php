<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Location</th>
        <th>State</th>
        <th>Timer</th>
        <th>Actions</th>
    </tr>
    @foreach($set as $tvconfig)
        <tr data-id="{{$tvconfig->id}}">
            <td>{{$tvconfig->id}}</td>
            <td>{{$tvconfig->location->name}}</td>
            <td>{{$tvconfig->state}}</td>
            <td>{{$tvconfig->screen_timer}}</td>
            <td>
                <a href="{{ route('admin.tvconfigs.edit', $tvconfig) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>