@extends('templates.crud_template')


@section('crud_form')

    <h1>Contract Status</h1>

    @if($contract == null)
        <h4>You have not yet signed a contract.</h4>
    @else
        <h2>Current Contract: {{ $contract::$name }}</h2>
        <h3>Requirements: </h3>

        @foreach ($contract->requirements->chunk(2) as $chunk)
            <div class="row">
                @foreach ($chunk as $requirement)
                    <div class="col-md-6 panel">
                        <h4>{{$requirement::$name}}</h4>
                        <div class="progress">
                            <div class="progress-bar {{$requirement->getPercentDone() == 100 ? 'progress-bar-success' : ''}}" role="progressbar" aria-valuenow="{{$requirement->getPercentDone()}}" aria-valuemin="0"
                                 aria-valuemax="100" <?php echo 'style="width:'.$requirement->getPercentDone().'%"' ?>">
                                <span class="sr-only">{{$requirement->getPercentDone()}}% Complete</span>
                            </div>
                        </div>
                        <p>Required: {{ $requirement->getThreshold() }}</p>
                        <p>Current: {{ round($requirement->getValue(),2) }}</p>
                        {!! $requirement->getDetails($user) !!}
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
@endsection