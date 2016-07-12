<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Price</th>
        <th>Bidder user name</th>
        <th>Item</th>
    </tr>
    @foreach($set as $bid)
        <tr data-id="{{$bid->id}}">
            <td>{{$bid->id}}</td>
            <td>{{$bid->bidder->user->name}}</td>
            <td>{{$bid->item->name}}</td>
            <td>
                <a href="{{ route('admin.positions.edit', $position) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>