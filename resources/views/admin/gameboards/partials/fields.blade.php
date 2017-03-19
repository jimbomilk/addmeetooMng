<div class="form-group">


    {!! Form::label('activity', Lang::get('label.activity')) !!}
    {!! Form::select('activity_id', $activities, null, ['id' => 'activity', 'class' => 'form-control']) !!}

    {!! Form::label('location', Lang::get('label.location')) !!}
    {!! Form::select('location_id', $locations, null, ['id' => 'location', 'class' => 'form-control']) !!}


    {!! Form::label('name', Lang::get('label.name')) !!}
    {!! Form::text('name', null, array('class'=>'form-control','placeholder'=>Lang::get('label.name'))) !!}

    {!! Form::label('deadline', Lang::get('label.deadline')) !!}
    {!! Form::number('deadline', null, array('class'=>'form-control','placeholder'=>Lang::get('label.deadline'))) !!}

    {!! Form::label('status', Lang::get('label.status')) !!}
    {!! Form::select('status', $statuses,null, ['id' => 'status', 'class' => 'form-control']) !!}

</div>
