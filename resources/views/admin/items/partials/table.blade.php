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
                <a href="{{ route('admin.auctions.edit', $item->auction) }}">Auction #</a></td>
            <td>

            <td>
                @if (!isset($item->auction))
                    <a href="{{ route('admin.auctions.create', $item) }}" class="btn-edit">Create Auction</a>
                @endif
            </td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$item))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$item))
            </td>
        </tr>
    @endforeach

</table>
