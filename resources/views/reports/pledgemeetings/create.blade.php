@extends('templates.crud_template')


@section('crud_form')

    <h1 class="page-header">Create a Pledge Meeting</h1>

    <create_pledge_meeting_form inline-template>
        {!! Form::open(['route'=>['report_store','type'=>'pledge_meetings'],'class'=>'collapse in','v-el'=>'iform'])
        !!}

        <div class="form-horizontal">

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('event_date','Date') !!}
                    <p class="help-block"></p>
                    {{--<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>--}}
                </div>
                <div class="col-sm-10">
                    {!! Form::input('date','event_date', null,
                    ['class'=>'form-control','v-model'=>'form.event_date']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('description','Minutes') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-10">
                    {!! Form::textarea('description', null, ['class'=>'form-control','v-model'=>'form.description']) !!}
                </div>
                <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>

        <div class="form-horizontal">
            <h2>Brothers at Meeting</h2>

            <p class="help-block"></p>
            <td><select id="brotherselecter" placeholder="Search for a Brother..." class="form-control"></select></td>
            <!-- Brothers listing -->
            <table class="table table-hover">
                <thead>
                <th>Brother</th>
                <th></th>
                </thead>
                <tbody>
                <tr v-repeat="brother: form.brothers">
                    <td>@{{ brother.name }}</td>
                    <td>
                        <div class="btn btn-danger" v-on="click: removeBrother(brother)">Remove</div>
                    </td>
                </tr>
                </tbody>
            </table>

            <br>
            <br>

            <div class="form-group">
                {!! Form::submit('Create Pledge Meeting', ['class'=>'btn btn-primary form-control']) !!}
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
    </create_pledge_meeting_form>

@endsection