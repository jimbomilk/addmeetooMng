
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Results</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $activity_option)
        <tr data-id="{{$activity_option->id}}">
            <td>{{$activity_option->description}}</td>
            <td><a href="#" class="fastEdit" data-type="number" data-column="result" data-url="{{route('activity_option_fast',['id'=>$activity_option->id])}}" data-pk="{{$activity_option->id}}" data-name="result"> {{$activity_option->result}} </a> </td>
            <td>
                <a href="{{ route('admin.activity_options.edit', $activity_option) }}" class="btn-edit"><i class="fa fa-pencil"></i></a>

            </td>
            <td>
                <a href="#!" class="btn-delete"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    @endforeach

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