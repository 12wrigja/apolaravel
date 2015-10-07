@extends('templates.crud_template')


@section('crud_form')

    <h1 class="page-header">Submit a Brotherhood Report</h1>

    <p>Please provide the following information. This service report is submitted to the Membership VP, who keeps
        track of all service hours.</p>

    <p>Contact the Membership VP with any questions at membership@apo.case.edu</p>

    <create_brotherhood_report_form inline-template>
        {!! Form::open(['route'=>[$mode,'type'=>'brotherhood_reports'],'class'=>'collapse in','v-el'=>'iform'])
        !!}

            @include('reports.brotherhoodreports.form')

            <br>
            <br>

            <div class="form-group">
                {!! Form::submit('Submit Report', ['class'=>'btn btn-primary form-control']) !!}
            </div>
            <div class="form-group">
                <div class="btn btn-danger form-control" v-on="click: confirmClearForm()">Clear Form</div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
            <h3 class="text-center">Submitting Report...</h3>

            <div class="progress">
                <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100"
                     aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
            </div>
        </div>
        <div class="alert alert-success alert-important collapse" role="alert" v-el="successArea">
            <h3 class="text-center">Report submitted!</h3>

            <div class="text-center">
                <div class="btn btn-info" v-on="click: startOver()">Submit another report</div>
                <a class="btn btn-success" href="{{route('home')}}">Return to home</a>
            </div>
        </div>
    </create_brotherhood_report_form>

@endsection