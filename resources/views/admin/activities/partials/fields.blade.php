<div class="form-group">
    {!! Form::label('name', Lang::get('label.act_name')) !!}
    {!! Form::text('name', null, array('class'=>'form-control','placeholder'=>Lang::get('label.act_desc_name'))) !!}
    {!! Form::label('type', Lang::get('label.act_type')) !!}
    {!! Form::select('type', ['' => 'Select one','vote'=>'Voting' ,'bet'=>'Betting','game'=>'Game'],null, ['class'=>'form-control']) !!}
</div>

