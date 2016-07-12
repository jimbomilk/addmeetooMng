<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Description</th>
        <th>Barcode</th>
        <th>Actions</th>
    </tr>
    @foreach($set as $position)
        <tr data-id="{{$position->id}}">
            <td>{{$position->id}}</td>
            <td>{{$position->description}}</td>
            <td>{{$position->barcode}}</td>
            <td>
                <a href="{{ route('admin.positions.edit', $position) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>