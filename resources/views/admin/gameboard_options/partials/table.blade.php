
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th>Description</th>
        <th>Image</th>
        <th>Results</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $gameboard_option)
        <tr data-id="{{$gameboard_option->id}}">
            <td>{{$gameboard_option->description}}</td>
            <td>{!! HTML::image('images/'.$gameboard_option->image, 'photo',array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td>{{$gameboard_option->result}}</td>
            <td>
                @if(!$gameboard_option->gameboard->auto)
                    @include("admin.common.btn_edit",array('var'=>$gameboard_option))
                @endif
            </td>

            <td>
                @if(!$gameboard_option->gameboard->auto)
                    @include("admin.common.btn_delete",array('var'=>$gameboard_option))
                @endif
            </td>

        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>

