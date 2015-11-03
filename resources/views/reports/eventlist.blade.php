<table class="table">
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
            <td>{{round($report->EventType->getValueForUser($currentUser)/60)}}</td>
            <td>{{$report->EventType->getValueForUser($currentUser)%60}}</td>
        </tr>
    @endforeach
</table>