<table class="table table-striped">
    <tr>
        <th>{{trans('labels.packid')}}</th>
        <th>{{trans('labels.startdate')}}</th>
        <th>{{trans('labels.enddate')}}</th>
        <th>{{trans('labels.bigdisplayed')}}</th>
        <th>{{trans('labels.smalldisplayed')}}</th>
        <th></th>
        <th></th>

    </tr>
    @foreach($set as $adspack)
        <tr data-id="{{$adspack->id}}">
            <td>{{$adspack->advertisement->name}}</td>
            <td>{{$adspack->visibleStartdate}}</td>
            <td>{{$adspack->visibleEnddate}}</td>

            <td>{{$adspack->bigdisplayed}}</td>
            <td>{{$adspack->smalldisplayed}}</td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$adspack))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$adspack))
            </td>


        </tr>
    @endforeach
    <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>

</table>