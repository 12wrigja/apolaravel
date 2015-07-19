@extends('templates.crud_template')


@section('crud_form')

    <h1 class="page-header">Submit a Service Report</h1>

    <p>Please provide the following information. When adding brothers/pledges to this report, please add the name of the
        of the person submitting the form as well. This service report is submitted to the Membership VP, who keeps
        track of all service hours.</p>

    <p>If you are unfamilar with the service hours guidelines they can be found here.</p>

    <p>Contact the Membership VP with any questions at membership@apo.case.edu</p>

    <create_service_report_form inline-template>
        {!! Form::open(['route'=>['report_store','type'=>'service_reports'],'class'=>'collapse in','v-el'=>'iform']) !!}

        <div class="form-group">

            {!! Form::label('display_name','Project Name') !!}
            <p class="help-block"></p>
            {!! Form::text('display_name', null, ['class'=>'form-control','v-model'=>'form.display_name']) !!}
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
        </div>

        <div class="form-group">
            {!! Form::label('description','Description') !!}
            <p class="help-block"></p>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            {!! Form::textarea('description', null, ['class'=>'form-control','v-model'=>'form.description']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('event_date','Date') !!}
            <p class="help-block"></p>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            {!! Form::input('date','event_date', null, ['class'=>'form-control','v-model'=>'form.event_date']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('location','Project Location') !!}
            <p class="help-block"></p>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            {!! Form::text('location', null, ['class'=>'form-control','v-model'=>'form.location']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('off_campus','Off Campus') !!}
            <p class="help-block"></p>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            {!! Form::select('off_campus', ['0'=>'No','1'=>'Yes'], '0' ,['class'=>'form-control','v-model'=>'form.off_campus']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('travel_time','Travel Time') !!}
            <p class="help-block"></p>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            {!! Form::text('travel_time', null, ['class'=>'form-control','v-model'=>'form.travel_time', 'v-attr'=>'disabled : form.off_campus | isFalse ']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create Contract', ['class'=>'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}
    </create_service_report_form>

@endsection