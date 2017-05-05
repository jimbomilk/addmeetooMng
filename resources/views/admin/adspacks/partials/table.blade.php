<table class="table table-striped">
    <tr>
        <th>Ads name</th>
        <th>Big packs</th>
        <th>Small packs</th>
        <th>Total Ads</th>
        <th>Total Cost</th>
        <th>Big displayed</th>
        <th>Small displayed</th>
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