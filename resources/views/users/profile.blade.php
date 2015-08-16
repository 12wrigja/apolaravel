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

                    <p>Pledge
                        Semester: {{ucwords($user->pledge_semester->semester)}} {{$user->pledge_semester->year}}</p>

                    <p>Initiation
                        Semester: {{ucwords($user->initiation_semester->semester)}} {{$user->initiation_semester->year}}</p>

                    <p>Graduation
                        Semester: {{ucwords($user->initiation_semester->semester)}} {{$user->initiation_semester->year}}</p>

                    <p>Family: {{$user->family()->name}}</p>
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

        <div class="row">
            <div class="col-sm-6">
                <h2>Contract Status</h2>
                <h4>Current Contract: {{$user->currentContract()->display_name}} (
                @if($contractPassing)
                    Passed!
                @else
                    Not Passing
                @endif
                    )
                    </h4>
                @if(count($requirements) == 0)
                    <h4>No Requirements for this contract.</h4>
                @else
                    <h4>Requirements: </h4>
                    @foreach($requirements as $index=>$requirement)
                        <h5>{{$requirement->display_name}} (
                            @if($requirementStatuses[$requirement->id]['passing'])
                                Passed
                            @else
                                Not Passed
                            @endif
                            {{$requirementStatuses[$requirement->id]['value']}} / {{$requirement->threshold}}
                            ) </h5>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop