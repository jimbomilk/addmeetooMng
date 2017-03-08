<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $activity)
        <tr data-id="{{$activity->id}}">
            <td>{{$activity->name}}</td>
            <td>
                <a href="{{ route('admin.activities.edit', $activity) }}" class="btn-edit"><i class="fa fa-pencil"></i></a>
            </td>

            <td>
                <a href="{{ route('admin.activities.show', $activity) }}" class="btn-edit"><i class="fa fa-list-ul"></i></a>
            </td>
            <td>
                {!! Form::open(['method' => 'DELETE','route' => ['admin.activities.destroy', $activity],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach

</table>