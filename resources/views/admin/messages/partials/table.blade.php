<table class="table table-striped">
    <tr>
        <th>{{trans('label.messages.date')}}</th>
        <th>{{trans('label.messages.type')}}</th>
        <th>{{trans('label.messages.stext')}}</th>
        <th></th>
    </tr>
    @foreach($set as $message)
        <tr data-id="{{$message->id}}">
            <td>
                Del {{$message->visibleStart}} al {{$message->visibleEnd}}
            </td>
            <td>{{$message->type}}</td>
            <td>{{$message->stext}}</td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$message))
                @include("admin.common.btn_delete",array('var'=>$message))
                <a href="{{ route('admin.messages.show', $message->id) }}" class="btn-edit"><i class="btn btn-primary">{{trans('labels.send')}}</i></a>
            </td>

        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>

</table>