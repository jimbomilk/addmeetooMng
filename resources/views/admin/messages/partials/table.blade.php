<table class="table table-striped">
    <tr>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Short Text</th>
        <th>Long Text</th>

        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $message)
        <tr data-id="{{$message->id}}">
            <td>
                Del {{$message->visibleStart}} al {{$message->visibleEnd}}
            </td>
            <td>{{$message->type}}</td>
            <td>{{$message->stext}}</td>
            <td>{{$message->ltext}}</td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$message))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$message))
            </td>

           <td>
                <a href="{{ route('admin.messages.show', $message->id) }}" class="btn-edit"><i class="btn btn-primary">Send</i></a>
            </td>

        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>

</table>