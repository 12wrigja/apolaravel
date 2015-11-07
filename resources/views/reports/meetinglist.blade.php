<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th>Type</th>
        <th>Meeting Date</th>
    </tr>
    </thead>
    @foreach($reports as $report)
        <tr>
            <td>
                @if($report->EventType instanceof \APOSite\Models\Contracts\Reports\Types\ChapterMeeting)
                    Chapter Meeting
                @elseif($report->EventType instanceof \APOSite\Models\Contracts\Reports\Types\PledgeMeeting)
                    Pledge Meeting
                @elseif($report->EventType instanceof \APOSite\Models\Contracts\Reports\Types\ExecMeeting)
                    Exec Meeting
                @else
                    Unknown
                @endif
            </td>
            <td>{{$report->EventType->event_date->toFormattedDateString()}}</td>
        </tr>
    @endforeach
</table>