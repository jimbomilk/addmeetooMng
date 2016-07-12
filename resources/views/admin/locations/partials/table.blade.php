<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Map</th>
        <th>Actions</th>
    </tr>
    @foreach($set as $location)
        <tr data-id="{{$location->id}}">
            <td>{{$location->id}}</td>
            <td>{{$location->name}}</td>
            <td><a href="http://www.google.com/maps/place/{{$location->geolocation}}">map</a> </td>
            <td>
                <a href="{{ route('admin.locations.edit', $location) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>