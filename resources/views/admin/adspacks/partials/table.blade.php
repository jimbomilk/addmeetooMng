<table class="table table-striped">
    <tr>
        <th>{{trans('labels.packid')}}</th>
        <th>{{trans('labels.bigpacks')}}</th>
        <th>{{trans('labels.smallpacks')}}</th>
        <th>{{trans('labels.totalads')}}</th>
        <th>{{trans('labels.totalcost')}}</th>
        <th>{{trans('labels.bigdisplayed')}}</th>
        <th>{{trans('labels.smalldisplayed')}}</th>
        <th></th>
        <th></th>

    </tr>
    @foreach($set as $adspack)
        <tr data-id="{{$adspack->id}}">
            <td>{{$adspack->advertisement->name}}</td>
            <td>{{$adspack->bigpack}}</td>
            <td>{{$adspack->smallpack}}</td>
            <td>{{$adspack->totalAds()}}</td>
            <td>{{$adspack->totalCost()}}&euro;</td>
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
    <div class="pagination"> {{ $set->links() }} </div>

</table>