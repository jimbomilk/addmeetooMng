<!-- Chat box -->
<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-comments-o"></i>
        <h3 class="box-title">Incidencias</h3>
        <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
            <div class="btn-group" data-toggle="btn-toggle" >
                <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
            </div>
        </div>
    </div>
    <div class="box-body chat" id="chat-box">

        @foreach($incidences as $incidence)
            <div class="item">
                <img src="{{$incidence->attachment}}" alt="incidence image" class="online"/>
                <p class="message">
                    <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{$incidence->create_at}}</small>
                        @if ($incidence->user_email!="")
                            {{$incidence->user_email}}
                        @else
                            Anónimo
                        @endif
                    </a>
                    Incidencia localizada en {{$incidence->coords}}. Para ver el mapa pulsar este <a href='https://www.google.es/maps/place/{{$incidence->coords}}'>enlace</a>
                </p>
            </div>
        @endforeach


        <!--
        <div class="item">
            <img src="dist/img/user4-128x128.jpg" alt="user image" class="online"/>
            <p class="message">
                <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                    Mike Doe
                </a>
                I would like to meet you to discuss the latest news about
                the arrival of the new theme. They say it is going to be one the
                best themes on the market
            </p>
            <div class="attachment">
                <h4>Attachments:</h4>
                <p class="filename">
                    Theme-thumbnail-image.jpg
                </p>
                <div class="pull-right">
                    <button class="btn btn-primary btn-sm btn-flat">Open</button>
                </div>
            </div>
        </div>-->

    </div><!-- /.chat -->

</div><!-- /.box (chat box) -->