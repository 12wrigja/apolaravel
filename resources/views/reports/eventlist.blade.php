<table class="table table-hover table-responsive table-bordered">
    <thead>
    <tr>
        <th>Event Name</th>
        <th>Event Location</th>
        <th>Event Date</th>
        <th>Hours</th>
        <th>Minutes</th>
    </tr>
    </thead>
    @foreach($reports as $report)
        <tr>
            <td>{{$report->EventType->event_name}}</td>
            <td>{{$report->EventType->location}}</td>
            <td>{{$report->EventType->event_date->toFormattedDateString()}}</td>
            <td>{{floor($report->EventType->getValueForUser($user)/60.0)}}</td>
            <td>{{$report->EventType->getValueForUser($user)%60}}</td>
        </tr>
    @endforeach
</table>