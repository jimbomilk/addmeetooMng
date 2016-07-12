<div class="form-group">
    {!! Form::label('state', 'Status') !!}
    {!! Form::select('state', ['' => 'Select one','live'=>'Live' ,'pause'=>'Pause'],null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('timer', 'Timer') !!}
    {!! Form::number('screen_timer',null,['class'=>'form-control','placeholder'=>'Screen timer rollout'] ) !!}
</div>

<div class="form-group">
    {!! Form::label('location', 'Location') !!}
    {!! Form::select('location_id',(['0' => 'Select a Location'] + $locations),null,['class'=>'form-control']) !!}
</div>

