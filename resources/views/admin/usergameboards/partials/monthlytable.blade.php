<table class="table table-striped">
    <tr>
        <th>Rank</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Puntos</th>

    </tr>
    @foreach($set as $indexKey => $userrank)
        <tr data-id="{{$userrank->id}}">
            <td>{{$indexKey+1}}</td>
            <td>{{$userrank->name}}</td>
            <td>{{$userrank->email}}</td>
            <td>{{$userrank->points}}</td>

        </tr>
    @endforeach

</table>