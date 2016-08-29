@extends('templates.crud_template')


@section('crud_form')

    <h1 class="page-header">Create an Exec Meeting</h1>

    <create_chapter_meeting_form inline-template>
        {!! Form::open(['route'=>['report_store','type'=>'exec_meetings'],'class'=>'collapse in','v-el'=>'iform'])
        !!}

            @include('reports.execmeetings.form')

            <br>
            <br>

            <div class="form-group">
                {!! Form::submit('Create Exec Meeting', ['class'=>'btn btn-primary form-control']) !!}
            </div>
            <div class="form-group">
                <div class="btn btn-danger form-control" v-on="click: confirmClearForm()">Clear Form</div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
            <h3 class="text-center">Creating Meeting...</h3>

            <div class="progress">
                <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100"
                     aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
            </div>
        </div>
        <div class="alert alert-success alert-important collapse" role="alert" v-el="successArea">
            <h3 class="text-center">Meeting created!</h3>

            <div class="text-center">
                <div class="btn btn-info" v-on="click: startOver()">Create another meeting</div>
                <a class="btn btn-success" href="{{route('home')}}">Return to home</a>
            </div>
        </div>
    </create_chapter_meeting_form>

@endsection