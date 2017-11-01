<!-- TO DO List -->
<div class="box box-primary">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>
        <h3 class="box-title">Mensajes</h3>

    </div><!-- /.box-header -->
    <div class="box-body">
        <ul class="todo-list">
            @foreach($messages as $msg)
            <li>
                <img src="{{$msg->image}}" width="75" height="50" alt="add image" class="online"/>
                <!-- todo text -->
                <span class="text">{!! $msg->ltext !!}</span>

            </li>
            @endforeach
            <span class="box-tools pull-right inline">
            {{ $messages->links() }}
            </span>

        </ul>
    </div><!-- /.box-body -->

</div><!-- /.box -->