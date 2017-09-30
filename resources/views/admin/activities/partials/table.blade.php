<table class="table table-striped">
    <tr>
        <th>{{Lang::get('label.activities.name')}}</th>
        <th>{{Lang::get('label.activities.description')}}</th>
        <th></th>
    </tr>
    @foreach($set as $activity)
        <tr data-id="{{$activity->id}}">
            <td>{{$activity->name}}</td>
            <td>{{$activity->description}}</td>
            <td>
                @include("admin.common.btn_edit",array('var'=>$activity))

                @include("admin.common.btn_show",array('var'=>$activity))

                @include("admin.common.btn_delete",array('var'=>$activity))
            </td>
        </tr>
    @endforeach
    <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>
</table>