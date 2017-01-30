<table class="table table-striped">
    <tr>
        <th>Name</th>
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
                <a href="#!" class="btn-delete"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    @endforeach

</table>