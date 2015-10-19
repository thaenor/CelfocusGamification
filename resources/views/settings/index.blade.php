@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Settings</h1>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        	
        	<h2>Point settings</h2>
        	<p> The value of each type and priority of a ticket can be defined here. (use a number between 1 and 100)</p>
        	<hr/>

            {!! Form::open(['url'=>'settings/storepoints']) !!}
            <div class="form-group">
                {!! Form::label('criticalPointVal', 'How many points is a P1 (Critical) ticket worth:') !!}
                {!! Form::input('number', 'p1PointVal',$settings[0]->critical_point_val,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('highPointVal', 'How many points is a P2 (High) ticket worth:') !!}
                {!! Form::input('number', 'p2PointVal',$settings[0]->high_point_val,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mediumPointVal', 'How many points is a P3 (Medium) ticket worth:') !!}
                {!! Form::input('number', 'p3PointVal',$settings[0]->medium_point_val,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('lowPointVal', 'How many points is a P4 (Low) ticket worth:') !!}
                {!! Form::input('number', 'p4PointVal',$settings[0]->low_point_val,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('incPointVal', 'How many points is an Incident ticket worth:') !!}
                {!! Form::input('number', 'incidentPointVal',$settings[0]->inc_point_val,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('problemPointVal', 'How many points is a problem ticket worth:') !!}
                {!! Form::input('number', 'problemPointVal',$settings[0]->problem_point_val,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('serviceReqPointVal', 'How many points is a service request ticket worth:') !!}
                {!! Form::input('number', 'serviceReqPointVal',$settings[0]->servreq_point_val,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('warningPercent', 'At what percentage should there be minor penalties?') !!}
                {!! Form::input('number', 'warning_percentage',$settings[0]->warning_percent,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('penaltyPercent', 'At what percentage should there be major penalties?') !!}
                {!! Form::input('number', 'penalty_percentage',$settings[0]->penalty_percent,['class'=>'form-control', 'min'=>'1', 'max'=>'100', "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Save settings', ['class'=>'btn btn-primary form-control']) !!}
            </div>
            {!! Form::close() !!}


            <br/><hr/>
            <h2>Users to be ommited from leaderboard</h2>
            <p>OTRS records some temporary and managment user accounts that create and manage tickets. These users will 
            	appear in the dashboard by default, to ommit them write down their names in the text area bellow.</p>
            	<em>WARNING: the names must be separated by commas.</em>
            </hr>
            {!! Form::open() !!}
                <div class="form-group">
                {!! Form::textarea('notes', null, ['class' => 'field form-control']) !!}
            	</div>
            <div class="form-group">
                {!! Form::submit('Hide users', ['class'=>'btn btn-warning form-control']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>


@endsection