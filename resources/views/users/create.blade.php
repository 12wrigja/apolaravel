<user-create-form inline-template>
    {!! Form::open(['route'=>['user_store'],'class'=>'form-group collapse in','v-el'=>'iform'])!!}
    <div class="row form-row">
        <div class="form-group">
            <div class="col-sm-2 control-label">
                {!! Form::label('first_name','First Name') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-10">
                {!! Form::text('first_name', null, ['class'=>'form-control','v-model'=>'form.first_name']) !!}
            </div>
        </div>
    </div>

    <div class="row form-row">
        <div class="form-group">
            <div class="col-sm-2 control-label">
                {!! Form::label('last_name','Last Name') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-10">
                {!! Form::text('last_name', null, ['class'=>'form-control','v-model'=>'form.last_name']) !!}
            </div>
        </div>
    </div>

    <div class="row form-row">
        <div class="form-group">
            <div class="col-sm-2 control-label">
                {!! Form::label('cwru_id','CWRU ID') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-10">
                {!! Form::text('cwru_id', null, ['class'=>'form-control','v-model'=>'form.cwru_id']) !!}
            </div>
        </div>
    </div>

    <div class="row form-row">
        <div class="form-group">
            {!! Form::submit('Create Pledge', ['class'=>'btn btn-primary form-control']) !!}
        </div>
    </div>

    {!! Form::close() !!}

    <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
        <h3 class="text-center">Creating Pledge...</h3>

        <div class="progress">
            <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100"
                 aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
        </div>
    </div>
    <div class="alert alert-success alert-important collapse" role="alert" v-el="successArea">
        <h3 class="text-center">Success!</h3>

        <div class="btn btn-info" v-on="click: startOver()">Create another Pledge</div>
        <a href="#" class="btn btn-info">View all Pledges</a>

    </div>

    {!! Form::close() !!}
</user-create-form>