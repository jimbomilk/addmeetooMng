<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<table class="table table-striped">
    <tr>
        <th>{{trans('label.notifications.title')}}</th>
        <th>{{trans('label.notifications.text')}}</th>
        <th>{{trans('label.notifications.who')}}</th>
        <th></th>
    </tr>
    @foreach($set as $notification)
        <tr data-id="{{$notification->id}}">


            <td><a href="#" class="fastEdit" data-type="text" data-column="title" data-url="{{route($login_user->type.'.who_fast',['id'=>$notification->id])}}" data-pk="{{$notification->id}}" data-name="title"> {{$notification->title}} </a> </td>
            <td><a href="#" class="fastEdit" data-type="text" data-column="text" data-url="{{route($login_user->type.'.who_fast',['id'=>$notification->id])}}" data-pk="{{$notification->id}}" data-name="text"> {{$notification->text}} </a> </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                        {{$notification->who()}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="fastUpdate" data-url="{{route($login_user->type.'.who_fast',['id'=>$notification->id])}}" data-value="0" data-name="who"> A todos los usuarios</a>
                        </li>
                        @foreach($games as $game)
                            <li>
                                <a href="#" class="fastUpdate" data-url="{{route($login_user->type.'.who_fast',['id'=>$notification->id])}}" data-value="{{$game->id}}" data-name="who"> {{trans('label.notifications.participantes').$game->name}} </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </td>
            <td>
                @include("admin.common.btn_edit",array('var'=>$notification))
                @include("admin.common.btn_delete",array('var'=>$notification))
                @include("admin.common.btn_show",array('var'=>$notification))
            </td>

        </tr>
    @endforeach
    <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>

</table>

@section('scripts')
    <script>

        $('.fastUpdate').on('click', function(e){
            console.log(e);
            var url = $(this).attr('data-url');
            var name = $(this).attr('data-name');
            var value = $(this).attr('data-value');
            var token = $("#_token").data("token");

            $.post(url, {name:name,value:value,_token:token} ,
                    function(response){
                        if(response.status === 500) {
                            alert('Server error. Check entered data.');
                        } else {
                            location.reload();
                            // return "Error.";
                        }
                    }, "json");
        });

        $(document).ready(function() {
            $.fn.editable.defaults.mode = 'inline';
            //make username editable
            $('.fastEdit').editable({
                params: function (params) {
                    // add additional params from data-attributes of trigger element
                    params._token = $("#_token").data("token");
                    params.name = $(this).editable().data('name');
                    return params;
                },
                error: function (response, newValue) {
                    if (response.status === 500) {
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
