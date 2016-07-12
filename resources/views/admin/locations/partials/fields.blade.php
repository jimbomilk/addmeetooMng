<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Please enter your name'] ) !!}



</div>

<script type='text/javascript'>var centreGot = false;</script>
{!! $marker['map_js'] !!}

            <div class="panel panel-default">
                <div class="panel-heading">Map</div>

                <div class="panel-body">
                    {!! $marker['map_html'] !!}
                </div>
            </div>
