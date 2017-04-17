<table class="table table-striped">
    <tr>
        <th>Logo</th>
        <th>Name</th>
        <th>Country</th>
        <th>Address</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $location)
        <tr data-id="{{$location->id}}">
            <td>{!! HTML::image($login_user->type.'/images/'.$location->logo, 'location photo',array( 'width' => 70, 'height' => 70 )) !!}</td>
            <td>{{$location->name}}</td>
            <td>{{$location->country->name}}</td>
            <td>{{$location->address}}</td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$location))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$location))
            </td>

            <td>
                @include("admin.common.btn_other",array('route'=> 'location_restart','var'=>$location,'label'=>'restart'))
            </td>

        </tr>
    @endforeach
    <div class="pagination"> {{ $set->links() }} </div>
</table>