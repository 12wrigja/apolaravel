@extends('templates.crud_template')

@section('crud_form')
<h1>Contract Statuses for Pledges</h1>

<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#pledge" aria-controls="messages" role="tab"
                                   data-toggle="tab">Pledge Contracts</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade  in active" id="pledge">
            <h3>Pledge Contracts</h3>
            {!! \APOSite\ContractFramework\Contracts\PledgeContract::getReportTable($pledgeBrothers) !!}
        </div>
    </div>
</div>

@endsection