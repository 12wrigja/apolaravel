@extends('master_full')

@section('content')
    <div class="container">
        <h1>Editing Profile</h1>
        <a href="{{route('user_show',['id'=>$user->id])}}" class="btn btn-primary">Return to Profile (Don't Save)</a>
        <user-profile-editor inline-template>
            {!!  Form::open(['route'=>['user_update','cwruid'=>$user->id],'role'=>'form','class'=>'form-horizontal collapse in','method'=>'PUT','v-el'=>'iform'])  !!}
            <h3 class="text-center">About You</h3>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('nickname','Nickname') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-2">
                    {!! Form::text('nickname', $user->nickname, ['class'=>'form-control','v-model'=>'form.nickname']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('semester','Graduation Semester') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-2">
                    {!! Form::select('graduation_semester.semester', ['fall'=>'Fall','spring'=>'Spring'], ($user->graduation_semester!=null)?$user->graduation_semester->semester:null, ['class'=>'form-control','v-model'=>'form.graduation_semester.semester']) !!}
                </div>
                <div class="col-sm-1">
                    {!! Form::text('graduation_semester.year', ($user->graduation_semester!=null)?$user->graduation_semester->year:null, ['class'=>'form-control','v-model'=>'form.graduation_semester.year']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('major','Major') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-10">
                    {!! Form::text('major', $user->major, ['class'=>'form-control','v-model'=>'form.major']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('minor','Minor') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-10">
                    {!! Form::text('minor', $user->minor, ['class'=>'form-control','v-model'=>'form.minor']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('biography','Biography') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-10">
                    {!! Form::textarea('biography', $user->biography, ['class'=>'form-control','v-model'=>'form.biography']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('join_reason','Why did you join APO?') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-10">
                    {!! Form::textarea('join_reason', $user->join_reason, ['class'=>'form-control','v-model'=>'form.join_reason']) !!}
                </div>
            </div>

            <h3>Contact Info</h3>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('email','Email Address') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-10">
                    {!! Form::text('email', $user->email, ['class'=>'form-control','v-model'=>'form.email']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {!! Form::label('phone_number','Phone Number') !!}
                    <p class="help-block"></p>
                </div>
                <div class="col-sm-10">
                    {!! Form::text('phone_number', $user->phone_number, ['class'=>'form-control','v-model'=>'form.phone_number']) !!}
                </div>
            </div>

            <h3 class="text-center">Locations</h3>

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {!! Form::label('hometown','Hometown') !!}
                            <p class="help-block"></p>
                        </div>
                        <div class="col-sm-10">
                            {!! Form::text('hometown', $user->hometown, ['class'=>'form-control','v-model'=>'form.hometown']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {!! Form::label('campus_residence','On Campus Location') !!}
                            <p class="help-block"></p>
                        </div>
                        <div class="col-sm-10">
                            {!! Form::text('campus_residence', $user->campus_location, ['class'=>'form-control','v-model'=>'form.campus_residence']) !!}
                        </div>
                    </div>
                </div>
            </div>


            <h4 class="text-center">Off Campus Address</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {!! Form::label('address','Address') !!}
                            <p class="help-block"></p>
                        </div>
                        <div class="col-sm-10">
                            {!! Form::text('address', $user->address, ['class'=>'form-control','v-model'=>'form.address']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {!! Form::label('city','City') !!}
                            <p class="help-block"></p>
                        </div>
                        <div class="col-sm-10">
                            {!! Form::text('city', $user->city, ['class'=>'form-control','v-model'=>'form.city']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {!! Form::label('state','State') !!}
                            <p class="help-block"></p>
                        </div>
                        <div class="col-sm-10">
                            {!! Form::text('state', $user->state, ['class'=>'form-control','v-model'=>'form.state']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {!! Form::label('zip_code','Zip Code') !!}
                            <p class="help-block"></p>
                        </div>
                        <div class="col-sm-10">
                            {!! Form::text('zip_code', $user->zip_code, ['class'=>'form-control','v-model'=>'form.zip_code']) !!}
                        </div>
                    </div>
                </div>
            </div>

            {{--Picture--}}

            <div class="form-group">
                {!! Form::submit('Update Profile', ['class'=>'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}

            <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
                <h3 class="text-center">Updating Profile...</h3>

                <div class="progress">
                    <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100"
                         aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
                </div>
            </div>
            <div class="alert alert-success alert-important collapse" role="alert" v-el="successArea">
                <h3 class="text-center">Success!</h3>
                <p class="text-center">Redirecting to your profile...</p>
            </div>
        </user-profile-editor>
    </div>
@stop