<table class="table table-striped">
    <tr>
        <th>{{trans('label.locations.logo')}}</th>
        <th>{{trans('label.locations.name')}}</th>
        <th>{{trans('label.locations.countries_id')}}</th>
        <th>{{trans('label.locations.address')}}</th>
        <th>{{trans('label.locations.parent')}}</th>
        <th></th>

    </tr>
    @foreach($set as $location)
        <tr data-id="{{$location->id}}">
            <td>{!! HTML::image($location->logo, 'location photo',array( 'width' => 200, 'height' => 70 )) !!}</td>
            <td>{{$location->name}}</td>
            <td>{{$location->country->name}}</td>
            <td>{{$location->address}}</td>
            <td>

                @if (isset($location->parent))
                    {{$location->parent->name}}

                @endif

            </td>

            <td>
                @include("admin.common.btn_edit",array('var'=>$location))

                @include("admin.common.btn_delete",array('var'=>$location))

                @include("admin.common.btn_other",array('route'=> 'location_restart','var'=>$location,'label'=>'restart'))
            </td>

        </tr>
    @endforeach
    <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>
</table>