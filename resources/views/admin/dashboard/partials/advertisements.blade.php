<!-- TO DO List -->
<div class="box box-primary">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>
        <h3 class="box-title">Anuncios</h3>

    </div><!-- /.box-header -->
    <div class="box-body">
        <ul class="todo-list">
            @foreach($ads as $a)
            <li>
                <img src="{{$a->imagesmall}}" width="75" height="50" alt="add image" class="online"/>
                <!-- todo text -->
                <span class="text">{{$a->name}}</span>

                <!-- Emphasis label -->
                @foreach($a->adspacks() as $pack)
                    <span class="label label-info" style="font-size: 12px"> Pack  {{$pack->id}}, del {{$pack->visibleStartdate}} al {{$pack->visibleEnddate}}</span>
                    <span class="label label-danger" style="font-size: 12px"><i class="fa fa-television"></i> {{$pack->bigdisplayed}} impactos TV </span>
                    <span class="label label-primary" style="font-size: 12px"><i class="fa fa-mobile"></i> {{$pack->smalldisplayed}} impactos Móvil </span>
                @endforeach

            </li>
            @endforeach
            <span class="box-tools pull-right inline">
            {{ $ads->links() }}
            </span>

        </ul>
    </div><!-- /.box-body -->

</div><!-- /.box -->