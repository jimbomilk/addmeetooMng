<table class="table table-striped">
    <tr>
        <th>{{Lang::get('label.advertisements.name')}}</th>
        <th>{{Lang::get('label.advertisements.imagesmall')}}</th>
        <th>{{Lang::get('label.advertisements.textsmall')}}</th>
        <th></th>

    </tr>
    @foreach($set as $ads)
        <tr data-id="{{$ads->id}}">
            <td>{{$ads->name}}</td>
            <td>{!! HTML::image($ads->imagesmall, 'imagesmall',array( 'width' => 100, 'height' => 50 )) !!}</td>
            <td>{{$ads->textsmall1}}<br>{{$ads->textsmall2}}</td>
            <td>
                @include("admin.common.btn_edit",array('var'=>$ads))

                @include("admin.common.btn_show",array('var'=>$ads))

                @include("admin.common.btn_delete",array('var'=>$ads))
            </td>


        </tr>
    @endforeach
    <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>

</table>