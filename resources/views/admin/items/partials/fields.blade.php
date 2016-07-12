<div class="form-group">

    {!! Form::image($element->photo, 'photo') !!}
    {!! Form::file('photo') !!}

    {!! Form::label('name', 'name') !!}
    {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Please enter item description'] ) !!}

    {!! Form::label('initial_price', 'Initial Price') !!}
    {!! Form::number('initial_price', null, ['class'=>'form-control','placeholder'=>'Please enter initial price'] ) !!}

    {!! Form::label('max_price', 'Maximum Price') !!}
    {!! Form::number('max_price', null, ['class'=>'form-control','placeholder'=>'Please enter maximum price'] ) !!}

</div>

