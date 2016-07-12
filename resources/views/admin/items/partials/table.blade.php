<table class="table table-striped">
    <tr>

        <th>Photo</th>
        <th>Name</th>
        <th>Initial Price</th>
        <th>Maximum Price</th>
        <th>Auction</th>
        <th>Actions</th>

    </tr>
    @foreach($set as $item)
        <tr data-id="{{$item->id}}">
            <td>{!! HTML::image($item->photo, 'item photo') !!}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->initial_price}}</td>
            <td>{{$item->max_price}}</td>

            <td>
                <a href="{{ route('admin.auctions.edit', $item->auction) }}">Auction #{{$item->auction->id}}</a></td>
            <td>
                @if (!isset($item->auction))
                    <a href="{{ route('admin.auctions.create', $item) }}" class="btn-edit">Create Auction</a>
                @endif
                <a href="{{ route('admin.items.edit', $item) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>
