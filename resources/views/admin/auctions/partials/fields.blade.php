<div class="form-group">

    {!! Form::label('state', 'Status') !!}
    {!! Form::select('state', ['' => 'Select one','scheduled'=>'Scheduled' ,'running'=>'Running','finished'=>'Finished'],null, ['class'=>'form-control']) !!}

    {!! Form::label('start', 'Start Date/Time') !!}
     <div class="container">
        <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control"  value="{{isset($element)? $element->start:''}}"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker();
                });
            </script>
        </div>
    </div>

    {!! Form::label('duration', 'Duration') !!}
    {!! Form::number('duration', null, ['class'=>'form-control','placeholder'=>'For how long?'] ) !!}

    {!! Form::label('times', 'Times') !!}
    {!! Form::number('times', null, ['class'=>'form-control','placeholder'=>'How many times do u wanna repeat the same auction?'] ) !!}

</div>

