<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Grouping</th>
        <th>Selection</th>
        <th>Ranking System</th>
        <th>How works</th>
        <th>Category</th>
        <th>Location</th>
        <th>Position</th>
        <th>Duration</th>
        <th></th>
    </tr>
    @foreach($set as $activity)
        <tr data-id="{{$activity->id}}">
            <td>{{$activity->name}}</td>
            <td>{{$activity->grouping}}</td>
            <td>{{$activity->selection}}</td>
            <td>{{$activity->point_system}}</td>
            <td>{{$activity->how}}</td>
            <td>{{$activity->category->code}}</td>
            <td>{{$activity->location->name}}</td>
            <td>{{$activity->locationPosition->description}}</td>
            <td>{{$activity->duration}}</td>
            <td>

                <a href="{{ route('admin.activities.edit', $activity) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>