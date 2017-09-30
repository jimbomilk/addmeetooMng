
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th>{{Lang::get('label.gameboard_options.order')}}</th>
        <th>{{Lang::get('label.gameboard_options.description')}}</th>
        <th>{{Lang::get('label.gameboard_options.image')}}</th>
        <th>{{Lang::get('label.gameboard_options.result')}}</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $activity_option)
        <tr data-id="{{$activity_option->id}}">
            <td>{{$activity_option->order}}</td>
            <td>{{$activity_option->description}}</td>

            <td>{!! HTML::image($activity_option->image, 'photo',array( 'width' => 70, 'height' => 70 )) !!}</td>

            <td><a href="#" class="fastEdit" data-type="number" data-column="result" data-url="{{route('activity_option_fast',['id'=>$activity_option->id])}}" data-pk="{{$activity_option->id}}" data-name="result"> {{$activity_option->result}} </a> </td>
            <td>
                @include("admin.common.btn_edit",array('var'=>$activity_option))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$activity_option))
            </td>


        </tr>
    @endforeach
    <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>
</table>

@section('scripts')
    <script type= text/javascript>
        $(document).ready(function() {
            $.fn.editable.defaults.mode = 'inline';
            //make username editable
            $('.fastEdit').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params._token = $("#_token").data("token");
                    params.name = $(this).editable().data('name');
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });
        });
    </script>
@endsection