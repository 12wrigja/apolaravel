@extends('templates.crud_template')

@section('crud_form')

    <h1 class="page-header">Contract Signing and Management</h1>


    <h2>Contract Signing</h2>
    {!! Form::open(['route'=>'changeContractSigning']) !!}
    <div class="form-group">
        {!! Form::checkbox('contract_signing',1,\APOSite\GlobalVariable::ContractSigning()->value) !!} Enable contract
        signing
        </div>
    <div class="form-group">
        {!! Form::checkbox('mark_inactive',1,\APOSite\GlobalVariable::ShowInactive()->value) !!} Show anyone who didn't
        explicitly sign a contract as inactive (excludes advisers and alumni).
    </div>
    <div class="form-group">
        {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

    <h3>Contract Management</h3>

    <p>Below is the contract management tool. You can add in brothers whose contracts you wish to change, and upon
        submitting the form those brother's contracts will instantly be updated to reflect their new status.</p>
    <contract-manager inline-template>

        {!! Form::open(['route'=>['contract_store'],'class'=>'collapse in','v-el'=>'iform']) !!}
        <brother-selector brothers="@{{@ brothers}}" attributes="@{{brotherAttributes}}"
                          v-ref="broselector"></brother-selector>
        <br>
        <br>

        <div class="form-group">
            {!! Form::submit('Submit Contract Changes', ['class'=>'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
        <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
            <h3 class="text-center">Submitting Changes...</h3>

            <div class="progress">
                <div class="progress-bar  progress-bar-striped active" role="progressbar"
                     aria-valuenow="100"
                     aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
            </div>
        </div>
        <div class="alert alert-success alert-important collapse" role="alert" v-el="successArea">
            <h3 class="text-center">Contract Changes submitted!</h3>

            <div class="text-center">
                <div class="btn btn-info" v-on="click: startOver()">Submit more changes</div>
                <a class="btn btn-success" href="{{route('home')}}">Return to home</a>
            </div>
        </div>
    </contract-manager>

@endsection