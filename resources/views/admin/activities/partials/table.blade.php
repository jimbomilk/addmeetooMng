<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Start Time</th>
        <th>Duration</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $activity)
        <tr data-id="{{$activity->id}}">
            <td>{{$activity->name}}</td>
            <td>{{$activity->description}}</td>
            <td>{{$activity->starttime}}</td>
            <td>{{$activity->duration}}</td>
            <td>
                @include("admin.common.btn_edit",array('var'=>$activity))
            </td>

            <td>
                @include("admin.common.btn_show",array('var'=>$activity))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$activity))
            </td>
        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>