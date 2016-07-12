<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Please enter screen name'] ) !!}
</div>

<div class="form-group">
    {!! Form::label('order', 'Order') !!}
    {!! Form::number('order', null, ['class'=>'form-control','placeholder'=>'Please enter screen visualization order'] ) !!}
</div>

<div class="form-group">
    {!! Form::label('type', 'Type') !!}
    {!! Form::select('selection', ['' => 'Select one','top_rank'=>'Top Rank' ,'activity_rank'=>'Rank by Activity','messages'=>'TV Messages','advertisement'=>'Advertisements'],null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('state', 'Status') !!}
    {!! Form::select('selection', ['' => 'Select one','on'=>'On' ,'off'=>'Off'],null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('advertisement', 'Advertisement') !!}
    {!! Form::text('ad_text', null, ['class'=>'form-control','placeholder'=>'Please enter screen name'] ) !!}
</div>

<div class="form-group">
    {!! Form::image($element->ad_img, 'ad_img') !!}
    {!! Form::file('ad_img') !!}
</div>

<div class="form-group">
    {!! Form::label('activity', 'Activity') !!}
    {!! Form::select('activity_id',(['0' => 'Select an Activity'] + $activities),null,['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('tvconfig', 'TV Configuration') !!}
    {!! Form::select('tvconfig_id',(['0' => 'Select a TV Configuration'] + $tvconfigs),null,['class'=>'form-control']) !!}
</div>