<table class="table table-striped">
    <tr>
        <th>Logo</th>
        <th>Name</th>
        <th>Country</th>
        <th>City</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $location)
        <tr data-id="{{$location->id}}">
            <td>{{$location->logo}}</td>
            <td>{{$location->name}}</td>
            <td>{{$location->country}}</td>
            <td>{{$location->city}}</td>
            <td>
                <a href="{{ route("$login_user->type.locations.edit", $location) }}" class="btn-edit"><i class="fa fa-pencil"></i></a>
            </td>
            <td>
                <a href="#!" class="btn-delete"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    @endforeach

</table>