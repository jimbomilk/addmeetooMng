<table class="table table-striped">
    <tr>
        <th>{{Lang::get('label.advertisements.name')}}</th>
        <th>{{Lang::get('label.advertisements.imagebig')}}</th>
        <th>{{Lang::get('label.advertisements.imagesmall')}}</th>
        <th>{{Lang::get('label.advertisements.textbig')}}</th>
        <th>{{Lang::get('label.advertisements.textsmall')}}</th>
        <th>{{Lang::get('label.advertisements.edit')}}</th>
        <th>{{Lang::get('label.advertisements.packs')}}</th>
        <th></th>
    </tr>
    @foreach($set as $ads)
        <tr data-id="{{$ads->id}}">
            <td>{{$ads->name}}</td>
            <td>{!! HTML::image($ads->imagebig, 'imagebig',array( 'width' => 140, 'height' => 70 )) !!}</td>
            <td>{!! HTML::image($ads->imagesmall, 'imagesmall',array( 'width' => 70, 'height' => 35 )) !!}</td>
            <td>{{$ads->textbig1}}<br>{{$ads->textbig2}}</td>
            <td>{{$ads->textsmall1}}<br>{{$ads->textsmall2}}</td>
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