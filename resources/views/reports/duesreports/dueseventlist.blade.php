<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th>Payment Date</th>
        <th>Amount Paid</th>
    </tr>
    </thead>
    @foreach($reports as $report)
        <tr>
            <td>{{$report->EventType->report_date->toFormattedDateString()}}</td>
            <td>${{round($report->EventType->getValueForUser($user),2)}}</td>
        </tr>
    @endforeach
</table>