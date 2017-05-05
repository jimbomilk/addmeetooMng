<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Image</th>
        <th>Cabecera gran formato</th>
        <th>Cabecera pequeño formato</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $ads)
        <tr data-id="{{$ads->id}}">
            <td>{{$ads->name}}</td>
            <td>{!! HTML::image($login_user->type.'/images/'.$ads->imagesmall, 'location photo',array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td>{{$ads->textsmall1}}</td>
            <td>{{$ads->textbig1}}</td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$ads))
            </td>

            <td>
                @include("admin.common.btn_show",array('var'=>$ads))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$ads))
            </td>


        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>

</table>