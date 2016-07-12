<div class="form-group">
    {!! Form::label('code', 'Code') !!}
    {!! Form::text('code', null, ['class'=>'form-control','placeholder'=>'Please enter category code'] ) !!}

</div>
<div class="form-group">
    {!! Form::label('description', 'Description') !!}
    {!! Form::text('description', null, ['class'=>'form-control','placeholder'=>'Please enter description'] ) !!}
</div>

<div class="form-group">
    {!! Form::label('gender', 'Gender') !!}
    {!! Form::select('gender', ['' => 'Select one','male'=>'male' ,'female'=>'female', 'mixed' => 'mixed'],null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('minAge', 'Min Age') !!}
    {!! Form::text('minAge', null, ['class'=>'form-control','placeholder'=>'Please enter Min Age'] ) !!}

</div>
<div class="form-group">
    {!! Form::label('maxAge', 'Max Age') !!}
    {!! Form::text('maxAge', null, ['class'=>'form-control','placeholder'=>'Please enter Max Age'] ) !!}
</div>
