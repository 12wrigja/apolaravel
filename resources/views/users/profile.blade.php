@extends('master_full')

@section('masthead')

@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="{{$user->pictureURL()}}" class="ui image">
            </div>
            <div class="col-sm-6">
                <div>
                    <h1>{{$user->fullDisplayName()}}</h1>

                    <p>Pledge Semester:
                        @if($user->pledge_semester != null)
                            {{ucwords($user->pledge_semester->semester)}} {{$user->pledge_semester->year}}
                        @else
                            Unknown
                        @endif
                    </p>

                    <p>Initiation Semester:
                        @if($user->initiation_semester != null)
                            {{ucwords($user->initiation_semester->semester)}} {{$user->initiation_semester->year}}
                        @else
                            Unknown
                        @endif
                    </p>

                    <p>Graduation Semester:
                        @if($user->graduation_semester != null)
                            {{ucwords($user->graduation_semester->semester)}} {{$user->graduation_semester->year}}
                        @else
                            Unknown
                    @endif
                    <p>Family:
                        @if($user->family() != null)
                            {{$user->family()->name}}
                        @else
                            Unknown
                        @endif
                    </p>
                </div>
                <div>
                    <h2>About Me</h2>
                    <h4>Education</h4>
                    <h6>Major</h6>

                    <p>{{$user->major or "Unknown"}}</p>
                    <h6>Minor</h6>

                    <p>{{$user->minor or "Unknown"}}</p>
                    <h4>Biography</h4>

                    <p>{{$user->biography or "No Biography Found!"}}</p>
                    <h4>Why Did I Join APO?</h4>

                    <p>{{$user->join_reason or "No Reason Found!"}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h2>Locations</h2>
                <h4>On Campus: </h4>

                <p>{{$user->campus_residence}}</p>
                <h4>Off Campus</h4>

                <p>{{$user->address}}</p>

                <p>{{$user->city}}</p>

                <p>{{$user->state}}</p>

                <p>{{$user->zip_code}}</p>
            </div>

            <div class="col-sm-6">
                <h2>Contact</h2>

                <p>Email Address: {{$user->email_address}}</p>

                <p>Phone Number: {{$user->phone_number}}</p>
            </div>
        </div>
    </div>
@stop