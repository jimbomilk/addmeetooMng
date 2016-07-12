<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Order</th>
        <th>Type</th>
        <th>Status</th>
        <th>Advertisement</th>
        <th>Ads Photo</th>
        <th>Activity</th>
        <th>TV Config</th>
        <th>Actions</th>
    </tr>
    @foreach($set as $screen)
        <tr data-id="{{$screen->id}}">
            <td>{{$screen->name}}</td>
            <td>{{$screen->order}}</td>
            <td>{{$screen->type}}</td>
            <td>{{$screen->state}}</td>
            <td>{{$screen->ads_text}}</td>
            <td>{{$screen->ads_img}}</td>
            <td>{{$screen->activity->name}}</td>
            <td>{{$screen->tvconfig_id}}</td>
            <td>

                <a href="{{ route('admin.screens.edit', $screen) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>