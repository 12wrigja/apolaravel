<table class="table">
    <thead>
        <td>Event Name</td>
        <td>Event Location</td>
        <td>Hours</td>
        <td>Minutes</td>
    </thead>
    @foreach($reports as $report)
        <tr>
            <td>{{$report->event_name}}</td>
            <td>{{$report->location}}</td>
            <td>{{$report->getValueForUser($currentUser)/60}}</td>
            <td>{{$report->getValueForUser($currentUser)%60}}</td>
        </tr>
    @endforeach
</table>