@extends('templates.crud_template')


@section('crud_form')

    <h1>Contract Status</h1>

    @if($contract == null)
        <h4>You have not yet signed a contract.</h4>
    @else
        <h2>Current Contract: {{ $contract::$name }}</h2>
        <h3>Requirements: </h3>

        @foreach ($contract->requirements->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $requirement)
                    <div class="col-xs-4 panel">
                        <h4>{{$requirement::$name}}</h4>
                        <div class="progress">
                            <div class="progress-bar {{$requirement->getPercentDone() == 100 ? 'progress-bar-success' : ''}}" role="progressbar" aria-valuenow="{{$requirement->getPercentDone()}}" aria-valuemin="0"
                                 aria-valuemax="100" <?php echo 'style="width:'.$requirement->getPercentDone().'%"' ?>">
                                <span class="sr-only">{{$requirement->getPercentDone()}}% Complete</span>
                            </div>
                        </div>
                        <p>Required: {{ $requirement->getThreshold() }}</p>
                        <p>Current: {{ round($requirement->getValue(),2) }}</p>
                        {{-- @if($reports != null)
                             @foreach($reports as $report)
                                @if($report->report_type instanceof \APOSite\Models\Contracts\Reports\Types\ServiceReport)
                                    <p>Report Name: {{$report->report_type->event_name}}</p>
                                @else
                                    <p>Date: {{$report->report_type->date}}</p>
                                @endif
                            @endforeach
                        @endif --}}

                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
@endsection