<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th>Meeting Date</th>
    </tr>
    </thead>
    @foreach($reports as $report)
        <tr>
            <td>{{$report->EventType->event_date->toFormattedDateString()}}</td>
        </tr>
    @endforeach
</table>