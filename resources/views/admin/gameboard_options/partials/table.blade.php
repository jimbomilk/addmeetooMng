
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Results</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($set as $gameboard_option)
        <tr data-id="{{$gameboard_option->id}}">
            <td>{{$gameboard_option->description}}</td>
            <td><a href="#" class="fastEdit" data-type="number" data-column="result" data-url="{{route('gameboard_option_fast',['id'=>$gameboard_option->id])}}" data-pk="{{$gameboard_option->id}}" data-name="result"> {{$gameboard_option->result}} </a> </td>
            <td>
                <a href="{{ route('admin.gameboard_options.edit', $gameboard_option) }}" class="btn-edit"><i class="fa fa-pencil"></i></a>

            </td>
            <td>
                {!! Form::open(['method' => 'DELETE','route' => ['admin.gameboard_options.destroy', $gameboard_option],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
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