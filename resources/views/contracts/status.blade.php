@extends('templates.crud_template')

@section('crud_form')

    @if($user->id == $currentUser->id)
        <h1>Contract Status</h1>
    @else
        <h1>Contract Status ({{$user->getFullDisplayName()}})</h1>
    @endif

    @if($contract == null)
        @if($user->id != $currentUser->id)
            <p>{{$user->getFullDisplayName()}} has not signed a contract this semester.</p>
        @else
            <h4>You have not yet signed a contract.</h4>
            <p>If you sign a contract during this semester, any hours previously submitted will count toward that
                contract.</p>
        @endif
    @else
        <p>Current Contract: {{ $contract::$name }}</p>
        <h2>Requirements: </h2>
        @if(count($contract->requirements) > 0)
            @foreach ($contract->requirements->chunk(2) as $chunk)
                <div class="row">
                    @foreach ($chunk as $requirement)
                        <div class="col-md-6 panel">
                            <h3>{{$requirement::$name}}</h3>

                            <div class="progress">
                                <div class="progress-bar {{$requirement->getPercentDone() == 100 ? 'progress-bar-success' : ''}}"
                                     role="progressbar" aria-valuenow="{{$requirement->getPercentDone()}}"
                                     aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width:{{$requirement->getPercentDone()}}%;">
                                    <span class="sr-only">{{$requirement->getPercentDone()}}% Complete</span>
                                </div>
                            </div>
                            <p>Current: {{ round($requirement->getValue(),2) }},
                                Required: {{ $requirement->getThreshold() }}</p>
                            @if($requirement->getValue() > 0)
                                <h4 class="text-center">Approved</h4>
                                {!! $requirement->getDetails(false) !!}
                            @endif
                            @if($requirement->getPendingValue() > 0)
                                <h4 class="text-center">Pending</h4>
                                {!! $requirement->getDetails(true) !!}
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <p>There are no requirements for this contract.</p>
        @endif
    @endif
@endsection