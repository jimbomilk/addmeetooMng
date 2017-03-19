<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $game)
        <tr data-id="{{$game->id}}">

            <td>{{$game->name}}</td>
            <td>
                <a href="{{ route("$login_user->type.gameboards.edit", $game) }}" class="btn-edit"><i class="fa fa-pencil"></i></a>
            </td>
            <td>
                <a href="{{ route('admin.gameboards.show', $game) }}" class="btn-edit"><i class="fa fa-list-ul"></i></a>
            </td>
            <td>
                {!! Form::open(['method' => 'DELETE','route' => ['admin.gameboards.destroy', $game],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach

</table>