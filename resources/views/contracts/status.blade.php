@extends('templates.crud_template')


@section('crud_form')

    <h1>Contract Status</h1>

    @if($contract == null)
        <h4>You have not yet signed a contract.</h4>
    @else
        <h2>Current Contract: {{ $contract->display_name }}</h2>
        <h3>Requirements: </h3>
        @foreach($contract->requirements as $requirement)
            <h4>{{$requirement->display_name}}</h4>
            <p>Required: {{ $requirement->threshold }}</p>
            <?php $reports = $requirement->computeForUser($user)->count() ?>
            <p>Current: {{ $reports->count() }}</p>
            @foreach($reports as $report)
                <p>Report Name: {{$report->display_name}}</p>
                <p>View Report: {!! route('report_show',['id'=>$report->id]) !!} </p>
            @endforeach
        @endforeach
    @endif
@endsection