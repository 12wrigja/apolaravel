@extends('templates.crud_template')

@section('crud_form')
    <h1>Contract Statuses</h1>

    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#active" aria-controls="Active Contracts" role="tab" data-toggle="tab">Active Contracts</a>
            </li>
            <li role="presentation"><a href="#associate" aria-controls="Associate Contracts" role="tab" data-toggle="tab">Associate Contracts</a>
            </li>
            <li role="presentation"><a href="#pledge" aria-controls="messages" role="tab"
                                       data-toggle="tab">Pledge Contracts</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="active">
                <h3>Active Contracts</h3>
                {!! \APOSite\ContractFramework\Contracts\ActiveContract::getReportTable($activeBrothers) !!}
            </div>
            <div role="tabpanel" class="tab-pane fade" id="associate">
                <h3>Associate Contracts</h3>
                {!! \APOSite\ContractFramework\Contracts\AssociateContract::getReportTable($associateBrothers) !!}
            </div>
            <div role="tabpanel" class="tab-pane fade" id="pledge">
                <h3>Pledge Contracts</h3>
                {!! \APOSite\ContractFramework\Contracts\PledgeContract::getReportTable($pledgeBrothers) !!}
            </div>
        </div>
    </div>

@endsection