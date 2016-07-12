<table class="table table-striped">
    <tr>
        <th>Item</th>
        <th>State</th>
        <th>Start</th>
        <th>Duration</th>
        <th>Time left &nbsp&nbsp&nbsp&nbsp&nbsp</th>
        <th>Winner Bid</th>
        <th>Actions</th>

    </tr>
    @foreach($set as $auction)
        <tr data-id="{{$auction->id}}">
            <td>{{$auction->item->name}}</td>
            <td>{{$auction->state}}</td>
            <td><div id="start{{$auction->id}}"> <script>localDate('start{{$auction->id}}', '{{$auction->start}}')</script></div></td>
            <td>{{$auction->duration}}</td>
            <td>
                @if($auction->state != 'finished')
                    <div id="addmeetoo-countdown {{$auction->id}}"></div><script>countdown('{{$auction->start}}','{{$auction->duration}}','{{$auction->id}}')</script>
                @endif
            </td>
            <td><a href="{{ route('admin.bids.edit', $auction->winnerBid) }}"> {{$auction->winnerBid['price']}}</a></td>

            <td>
                <a href="{{ route('admin.auctions.edit', $auction) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>
