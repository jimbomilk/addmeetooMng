<!-- TO DO List -->
<div class="box box-primary">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>
        <h3 class="box-title">Anuncios</h3>
        <span class="box-tools pull-right inline" style="margin: 0px">
            {{ $ads->links() }}
        </span>
    </div><!-- /.box-header -->
    <div class="box-body">
        <ul class="todo-list">
            @foreach($ads as $a)
            <li>
                <!-- todo text -->
                <span class="text">{{$a->name}}</span>
                <!-- Emphasis label -->
                <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                <!-- General tools such as edit or delete-->
                <div class="tools">
                    <i class="fa fa-edit"></i>
                </div>

            @endforeach   </li>

        </ul>
    </div><!-- /.box-body -->

</div><!-- /.box -->