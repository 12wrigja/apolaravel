@extends('templates.crud_template')

@section('crud_form')




    <h2>Service Hours</h2>
    <p>Total Hours: {{$totalHours}}</p>
    <div class="row">
        <div class="col-sm-3">
            <piechart parts="{{$totalInsideHours}},#665|{{$totalOutsideHours}},yellowgreen"
                      bgcolor="yellowgreen"></piechart>
        </div>
        <div class="col-sm-3">
            <p>
                <svg width="15px" height="15px">
                    <rect width="15px" height="15px" fill="#665"></rect>
                </svg>
                Inside Hours: {{$totalInsideHours}}
            </p>
            <p>
                <svg width="15px" height="15px">
                    <rect width="15px" height="15px" fill="yellowgreen"></rect>
                </svg>
                Outside Hours: {{$totalOutsideHours}}
            </p>
        </div>
        <div class="col-sm-3">
            <piechart
                    parts="{{$totalChapterHours}},red|{{$totalCampusHours}},blue|{{$totalCommunityHours}},yellow|{{$totalCountryHours}},green"
                    bgcolor="black"></piechart>
        </div>
        <div class="col-sm-3">
            <p>
                <svg width="15px" height="15px">
                    <rect width="15px" height="15px" fill="red"></rect>
                </svg>
                Chapter Hours: {{$totalChapterHours}}</p>
            <p>
                <svg width="15px" height="15px">
                    <rect width="15px" height="15px" fill="blue"></rect>
                </svg>
                Campus Hours: {{$totalCampusHours}}</p>
            <p>
                <svg width="15px" height="15px">
                    <rect width="15px" height="15px" fill="yellow"></rect>
                </svg>
                Community Hours: {{$totalCommunityHours}}</p>
            <p>
                <svg width="15px" height="15px">
                    <rect width="15px" height="15px" fill="green"></rect>
                </svg>
                Country Hours: {{$totalCountryHours}}</p>

        </div>
    </div>



    <h2>Brotherhood Hours</h2>

    <h2>Contracts</h2>

    <p>Actives: {{$totalActiveContracts}}</p>
    <p>Associates: {{$totalAssociateContracts}}</p>
    <p>Pledges: {{$totalPledgeContracts}}</p>
    <p>Neophytes: {{$totalNeophyteContracts}}</p>

    <div class="row">
        <div class="col-sm-4">
            <h2>Active Contracts</h2>

            <p>Chapter Meetings: {{$activeChapterMeetings}}/{{$totalActiveContracts}}</p>

            <p>Pledge Meetings: {{$activePledgeMeetings}}/{{$totalActiveContracts}}</p>

            <p>Service Hours: {{$activeHours}}/{{$totalActiveContracts}}</p>

            <p>Brotherhood Hours: {{$activeBrotherhoodHours}}/{{$totalActiveContracts}}</p>

            <p>Dues Paid: {{$activeDues}}/{{$totalActiveContracts}}</p>

            <p>Contracts Complete: {{$activesComplete}}/{{$totalActiveContracts}}</p>
        </div>
        <div class="col-sm-4">
            <h2>Associate Contracts</h2>

            <p>Service Hours: {{$associateHours}}/{{$totalAssociateContracts}}</p>

            <p>Brotherhood Hours: {{$associateBrotherhoodHours}}/{{$totalAssociateContracts}}</p>

            <p>Dues Paid: {{$associateDues}}/{{$totalAssociateContracts}}</p>

            <p>Contracts Complete: {{$associatesComplete}}/{{$totalAssociateContracts}}</p>
        </div>
        <div class="col-sm-4">
            <h2>Pledge Contracts</h2>

            <p>Chapter Meetings: {{$pledgeChapterMeetings}}/{{$totalPledgeContracts}}</p>

            <p>Pledge Meetings: {{$pledgePledgeMeetings}}/{{$totalPledgeContracts}}</p>

            <p>Service Hours: {{$pledgeHours}}/{{$totalPledgeContracts}}</p>

            <p>Brotherhood Hours: {{$pledgeBrotherhoodHours}}/{{$totalPledgeContracts}}</p>

            <p>Dues Paid: {{$pledgeDues}}/{{$totalPledgeContracts}}</p>

            <p>Contracts Complete: {{$pledgesComplete}}/{{$totalPledgeContracts}}</p>
        </div>
    </div>

@endsection