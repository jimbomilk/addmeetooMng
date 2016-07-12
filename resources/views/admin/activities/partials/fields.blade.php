


        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                            </a>
                        </li>

                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                            </a>
                        </li>

                        <li role="presentation" class="disabled">
                            <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <form role="form">
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <h3>Step 1</h3>
                            <p>This is step 1</p>
                            <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Please enter activity name'] ) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('grouping', 'Grouping Type') !!}
                                {!! Form::select('grouping', ['' => 'Activity type','one'=>'Individual','pairs'=>'Couples' ,'trios'=>'Trios'],null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('selection', 'Selection Type') !!}
                                {!! Form::select('selection', ['' => 'Participant selection','random'=>'Randomly' ,'best'=>'Best Ranked'],null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('point_system', 'Points System') !!}
                                {!! Form::select('point_system', ['' => 'Select one','bytime'=>'By Time' ,'bypoints'=>'By Points'],null, ['class'=>'form-control']) !!}
                            </div>
                            <ul class="list-inline pull-right">

                                <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <h3>Step 2</h3>
                            <p>This is step 2</p>
                            <div class="form-group">
                                {!! Form::label('how', 'How to get points?') !!}
                                {!! Form::select('how', ['' => 'Select one','bypairing' => 'Pairing mobiles' ,'byposition' => 'By Position', 'voting' => 'Voting'],null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('category', 'Age Category') !!}
                                {!! Form::select('category_id',(['0' => 'Select a Category'] + $categories),null,['class'=>'form-control']) !!}
                            </div>

                            <ul class="list-inline pull-right">
                                <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step3">
                            <h3>Step 3</h3>
                            <p>This is step 3</p>
                            <div class="form-group">
                                {!! Form::label('location', 'Location') !!}
                                {!! Form::select('location_id',(['0' => 'Select a Location'] + $locations),null,['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('position', 'Position') !!}
                                {!! Form::select('location_position_id',(['0' => 'Select a Position'] + $positions),null,['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('duration', 'Duration') !!}
                                {!! Form::text('duration', null, ['class'=>'form-control','placeholder'=>'Please input duration'] ) !!}
                            </div>
                            <ul class="list-inline pull-right">
                                <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                                <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>Complete</h3>
                            <p>You have successfully completed all steps.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </section>










