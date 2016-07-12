<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Please enter your name'] ) !!}

</div>
<div class="form-group">
    {!! Form::label('email', 'E-Mail Address') !!}
    {!! Form::text('email', null, ['class'=>'form-control','placeholder'=>'Please enter your email'] ) !!}

</div>
<div class="form-group">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class'=>'form-control','placeholder'=>'Please input password']) !!}

</div>
<div class="form-group">
    {!! Form::label('password2', 'Repeat Password') !!}
    {!! Form::password('password2', ['class'=>'form-control','placeholder'=>'Please input password again']) !!}

</div>
<div class="form-group">
    {!! Form::label('type', 'Type') !!}
    {!! Form::select('type', ['' => 'Select type','user'=>'User','admin'=>'Admin'],null, ['class'=>'form-control']) !!}
</div>
