<!-- Chat box -->
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>

<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-comments-o"></i>
        <h3 id="titulo_incidencias" class="box-title">Incidencias abiertas</h3>
        <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
            <div class="btn-group" data-toggle="btn-toggle" >
                <button type="button" class="btn btn-default btn-sm active" onclick="$('.target0').show();$('.target1').hide();$('#titulo_incidencias').text('Incidencias abiertas')"><i class="fa fa-square text-green"></i></button>
                <button type="button" class="btn btn-default btn-sm" onclick="$('.target1').show();$('.target0').hide();$('#titulo_incidencias').text('Incidencias cerradas')"><i class="fa fa-square text-red"></i></button>
            </div>
        </div>
    </div>
    <div class="box-body chat" id="chat-box">


        @foreach($incidences as $incidence)
            <div class="item target{{$incidence->status}}" >
                <img src="{{$incidence->attachment}}" alt="incidence image" class="online"/>
                <p class="message">
                    <a href="#" class="name">
                        <div>
                        <small class="text-muted pull-right"><i class="fa fa-clock-o text-success"></i> {{$incidence->created_at}}</small>
                        </div>
                        @if ($incidence->status)
                        <div>
                        <small class="text-muted pull-right"><i class="fa fa-clock-o text-danger"></i> {{$incidence->updated_at}}</small>
                        </div>
                        @endif

                        @if ($incidence->user_email!="")
                            {{$incidence->user_email}}
                        @else
                            Anónimo
                        @endif
                    </a>
                    Incidencia localizada en {{$incidence->coords}}. Para ver el mapa pulsar este <a href='https://www.google.es/maps/place/{{$incidence->coords}}'>enlace</a>
                    @if (!$incidence->status)

                        <a href="#" class="fastUpdate" data-url="{{route($login_user->type.'.incidence_fast',['id'=>$incidence->id])}}" data-value="1" data-name="status">
                            <small class="label label-primary"><i class="fa fa-clock-o"></i> Cerrar</small>
                        </a>

                    @endif


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

