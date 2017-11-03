<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>


<table class="table borderless">
    <tr style="background-color: #dddddd">
        <th>{{Lang::get('label.gameboards.dates')}}</th>
        <th>{{Lang::get('label.gameboards.deadline')}}</th>
        @if($login_user->type=='admin')
            <th>{{Lang::get('label.locations.name')}}</th>
        @endif
        <th>{{Lang::get('label.gameboards.name')}}</th>
        <th>{{Lang::get('label.gameboards.category')}}</th>
        <th>{{Lang::get('label.gameboards.status')}}</th>

        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    @foreach($set as $key=>$game)
        @php $key%2==0?$bck='#ddeeff':$bck='#fffff' @endphp

        <tr data-id="{{$game->id}}" style="background-color:{{$bck}}">
            <td>
                Del {{$game->visibleStartgame}} al {{$game->visibleEndgame}}
            </td>
            <td>{{$game->visibleDeadline}}</td>

            @if($login_user->type=='admin')
                <td>{{$game->location->name}}</td>
            @endif
            <td>{{$game->name}}</td>
            <td>{{$game->activity->category}}</td>

            <td>
               <div class="btn-group">
                   <button type="button" class="btn btn-{{$colours[$game->status]}} dropdown-toggle" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                            {{$statuses[$game->status]}}
                       <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($statuses as $key=>$status)
                                <li>
                                   <a href="#" class="fastUpdate" data-url="{{route($login_user->type.'.gameboard_fast',['id'=>$game->id])}}" data-value="{{$key}}" data-name="status"> {{$status}} </a>
                                </li>
                        @endforeach
                    </ul>
                </div>
            </td>


            <td>
               @if($game->status < \App\Status::SCHEDULED)
                @include("admin.common.btn_edit",array('var'=>$game))
               @endif
            </td>

            <td>
                @include("admin.common.btn_show",array('var'=>$game))
            </td>

            <td>
                @if ($login_user->is('admin'))
                @include("admin.common.btn_other",array('route'=> 'gameboards_preview','var'=>$game,'label'=>'vista previa','style'=>'btn-danger'))
                @endif
            </td>

            <td>
                @include("admin.common.btn_other",array('route'=> 'gameboards_participants','var'=>$game,'label'=>'resultado','style'=>'btn-info'))
            </td>

            <td>
                @include("admin.common.btn_delete",array('var'=>$game))
            </td>


        </tr>
    @endforeach

    <tr style="background-color: #bbffbb"><th colspan="11"> Recuerda que para editar un juego , el juego no puede haber comenzado </th></tr>
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


    </script>
@endsection

