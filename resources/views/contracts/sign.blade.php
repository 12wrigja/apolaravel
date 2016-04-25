@extends('templates.crud_template')

@section('crud_form')
    <h1>Contract Signing</h1>
    @if(\APOSite\GlobalVariable::ContractSigning()->value)
        <p>Please select a tab in order to view the requirements for the various contracts. Clicking sign at the bottom
            of the page will sign whatever contract is currently visible.</p>
        @if($currentUser->initiation_semester == null || $currentUser->initiation_semester->id >= \APOSite\Models\Semester::currentSemester()->id)
            <p>It appears that you are a pledge this semester! Once you have initiated with APO you will be eligible to
                sign a contract the semester after. If you have any questions please contact the Pledge Educator at
                pledge.ed@apo.case.edu</p>
        @else
            <contract-signer inline-template>
                {!! Form::open(['route'=>['contract_store'],'class'=>'collapse in','v-el'=>'iform'])
            !!}
                <div>
                    <ul class="nav nav-tabs" role="tablist" id="contracttypelist">
                        @foreach($signableContracts as $index=>$contract)
                            <li role="presentation" @if($contract->display_order == 0)class="active" @endif data-contract-type="{{$contract->code}}"><a
                                        href="#{{strtolower($contract->contract_name)}}Contract"
                                        aria-controls="{{$contract->contract_name}}Contract"
                                        role="tab"
                                        data-toggle="tab"
                                        v-on="click: setContract('{{$contract->code}}')">{{$contract->metadata['name']}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($signableContracts as $contract)
                            <div role="tabpanel" @if($contract->contract_name == 'Active')class="tab-pane active"
                                 @else class="tab-pane" @endif id="{{strtolower($contract->contract_name)}}Contract">
                                <h4>Requirements:</h4>
                                <ul>
                                    @foreach($contract->metadata['requirements'] as $requirement)
                                        <li>{{$requirement}}</li>
                                    @endforeach

                                </ul>
                                {!! $contract->metadata['signingview'] !!}
                            </div>
                        @endforeach
                    </div>
                </div>
                {{--<pre>@{{form | json}}</pre>--}}
                <div class="form-group">
                    {!! Form::submit('Sign Contract', ['class'=>'btn btn-primary form-control']) !!}
                </div>
                {!! Form::close() !!}
                <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
                    <h3 class="text-center">Submitting Contract Change...</h3>

                    <div class="progress">
                        <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100"
                             aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
                    </div>
                </div>
                <div class="alert alert-success alert-important collapse" role="alert" v-el="successArea">
                    <h3 class="text-center">Contract Signed!</h3>

                    <div class="text-center">
                        <a class="btn btn-primary" href="{{route('user_status',['cwruid'=>$currentUser->id])}}">View
                            contract status</a>
                        <a class="btn btn-success" href="{{route('home')}}">Return to home</a>
                    </div>
                </div>
                <div class="alert alert-danger alert-important collapse" role="alert" v-el="errorArea">
                    <h3 class="text-center">Uh Oh!</h3>
                    <div class="help-block"></div>
                    <div class="text-center">
                        <a class="btn btn-success" href="{{route('home')}}">Return to home</a>
                    </div>
                </div>
            </contract-signer>
        @endif
    @else
        <h3>We're Sorry!</h3>
        <p>Contract signing is not enabled at this time. If you wish to change your contract, please contact the
            Membership VP at {!! Html::mailto('membership@apo.case.edu') !!}.</p>
    @endif

@endsection
