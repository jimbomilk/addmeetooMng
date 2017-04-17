
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th>Order</th>
        <th>Description</th>
        <th>Image</th>
        <th>Results</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $activity_option)
        <tr data-id="{{$activity_option->id}}">
            <td>{{$activity_option->order}}</td>
            <td>{{$activity_option->description}}</td>
            <td>{!! HTML::image($login_user->type.'/images/'.$activity_option->image, 'photo',array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td>{{$activity_option->Results}}</td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$activity_option))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$activity_option))
            </td>


        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>

