@extends('templates.crud_template')

@section('crud_form')
    <h1>Contract Signing</h1>
    @if(\APOSite\GlobalVariable::ContractSigning()->value)
        <p>Please select a tab in order to view the requirements for the various contracts. Clicking sign at the bottom
            of the page will sign whatever contract is currently visible.</p>
        @if($currentUser->initiation_semester == null || $currentUser->initiation_semester->id >= \APOSite\Models\Semester::currentSemester()->id)
            <p>It appears that you are a pledge this semester! Once you have initiated with APO you will be eligible to sign a contract the semester after. If you have any questions please contact the Pledge Educator at pledge.ed@apo.case.edu</p>
        @else
        <contract-signer inline-template>
            {!! Form::open(['route'=>['contract_store'],'class'=>'collapse in','v-el'=>'iform'])
        !!}
            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#activeContract" aria-controls="activeContract"
                                                              role="tab"
                                                              data-toggle="tab" v-on="click: setContract('Active')">Active</a>
                    </li>
                    <li role="presentation"><a href="#associateContract" aria-controls="associateContract" role="tab"
                                               data-toggle="tab" v-on="click: setContract('Associate')">Associate</a></li>
                    <li role="presentation"><a href="#memberInAbsentiaContract" aria-controls="emberInAbsentiaContract"
                                               role="tab"
                                               data-toggle="tab" v-on="click: setContract('MemberInAbsentia')">Member In Absentia</a></li>
                    <li role="presentation"><a href="#inactiveContract" aria-controls="inactiveContract" role="tab"
                                               data-toggle="tab" v-on="click: setContract('Inactive')">Inactive</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="activeContract">
                        <h4>Requirements:</h4>
                        <ol>
                            <li>Must have been initiated into the brotherhood.</li>
                            <li>Will pay membership dues by the sixth (6th) chapter meeting of each academic semester or
                                as
                                specifically arranged by the treasurer.
                            </li>
                            <li>Will attend at least eight (8) general chapter meetings each chapter semester.</li>
                            <li>Will attend at least one pledge meeting each chapter semester, unless excused by the
                                Executive Committee.
                            </li>
                            <li>Will complete a minimum of twenty (20) hours of service each chapter semester, ten (10)
                                of
                                which must be completed with ALPHA PHI OMEGA.
                            </li>
                            <li>Will complete a minimum of two (2) hours of brotherhood with ALPHA PHI OMEGA each
                                chapter
                                semester.
                            </li>
                            <li>Will be active on at least one (1) standing committee each chapter semester.</li>
                            <li>Will have full voting privileges and ability to hold any elected or appointed office.
                            </li>
                            <li>Will hold no more then one elected office at a time.</li>
                            <li>Must be in good academic standing as defined by the University.</li>
                        </ol>
                        <h4>Committees: </h4>

                        <p>Please rank the following committees from most to least preferred. They will move around as
                            you rate
                            them, and the order in which they are on the screen (from top to bottom, most to least
                            preferred) is the order that
                            will be submitted.</p>
                        <table class="table table-responsive">
                            <thead>
                            <th>Committee</th>
                            <th>Rating</th>
                            </thead>
                            <tr v-repeat="committee in form.committees | orderBy 'rating'">
                                <td>
                                    @{{ committee.name }}
                                </td>
                                <td>
                                    <div class="btn btn-success" v-on="click: decreaseRating(committee)">Higher</div>
                                    <div class="btn btn-danger" v-on="click: increaseRating(committee)">Lower</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="associateContract">
                        <h4>Requirements: </h4>
                        <ol>
                            <li>Must have been initiated into the brotherhood.</li>
                            <li>Must have requested associate membership status and been approved by the Executive
                                Committee.
                            </li>
                            <li>Will pay membership dues of one-half (1/2) an active brother's dues by the sixth (6th)
                                chapter meeting of each academic semester, or as specifically arranged by the Treasurer.
                            </li>
                            <li>Will complete a minimum of ten (10) hours of service with ALPHA PHI OMEGA each chapter
                                semester.
                            </li>
                            <li>Will complete a minimum of two (2) hours of brotherhood with ALPHA PHI OMEGA each
                                chapter
                                semester.
                            </li>
                            <li>Will be permitted to hold office or vote in the next chapter general elections if they
                                have
                                attended at least Four regular chapter meetings during the previous chapter semester and
                                pass membership review (see Section 13), or if they, with approval of the executive
                                committee, have completed a minimum of twenty service hours, serve on one committee and
                                have
                                passed membership review (see Section 13).
                            </li>
                            <li>Will have voice but no voting privileges.</li>
                        </ol>

                        <large>As a part of signing an associate contract, you will also be asked to <strong>fill out <a href="https://docs.google.com/forms/d/1KSIwk6IHRVXf6RIHAVYSdnAQ27cCRY7RCdnO6MCUUFQ/viewform" target="_blank">this
                                google form</a></strong>.
                            The
                            Theta Upsilon executive board will use your responses to determine if you are allowed to
                            sign an
                            associate contract this semester.
                        </large>
                        <h4>Committees: </h4>

                        <p>Please rank the following committees from most to least preferred. They will move around as
                            you rate
                            them, and the order in which they are on the screen (from top to bottom, most to least
                            preferred) is the order that
                            will be submitted.</p>
                        <table class="table table-responsive">
                            <thead>
                            <th>Committee</th>
                            <th>Rating</th>
                            </thead>
                            <tr v-repeat="committee in form.committees | orderBy 'rating'">
                                <td>
                                    @{{ committee.name }}
                                </td>
                                <td>
                                    <div class="btn btn-success" v-on="click: decreaseRating(committee)">Higher</div>
                                    <div class="btn btn-danger" v-on="click: increaseRating(committee)">Lower</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="memberInAbsentiaContract">
                        <h4>Requirements: </h4>
                        <ol>
                            <li>Must have been initiated into the brotherhood.</li>
                            <li>Will be on leave from the university for an extended period of time for reasons
                                including,
                                but not limited to, co-op, study abroad, medical condition, or personal problems.
                            </li>
                            <li>Will be able to run for office in general elections for the chapter semester that the
                                member
                                returns from being a member-in-absentia, if that member fulfilled his or her contractual
                                obligations for an active membership contract the chapter semester immediately prior to
                                becoming a member-in-absentia.
                            </li>
                            <li>Will be able to carry over hours and meeting credits from the chapter semester in which
                                the
                                member is a member-in-absentia into the chapter semester in which the member returns
                                from
                                being a member-in absentia.
                            </li>
                            <li>Shall be considered active in matters pertaining to the Distinguished Service Key if the
                                member-in-absentia returns a vote and has fulfilled his or her contractual obligations
                                for
                                an active membership contract the chapter semester immediately prior to becoming a
                                member-in-absentia.
                            </li>
                        </ol>
                        <p>We also ask that you check your profile after signing and make sure that your contact
                            information is up to date.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="inactiveContract">
                        <h4>Requirements: </h4>
                        <ol>
                            <li>Must have been initiated into the brotherhood.</li>
                            <li>Will not have any voting privileges or the ability to hold any office.</li>
                            <li>Will not be required to pay dues or be subject to any other contractual obligations of
                                an
                                active brother.
                            </li>
                        </ol>

                        <p>Please explain why you are going inactive this semester, or what could have been done better
                            by
                            the chapter. </p>

                        <div class="form-group">
                            <div class="col-sm-2 control-label">
                                {!! Form::label('reason','Reason') !!}
                                <p class="help-block"></p>
                            </div>
                            <div class="col-sm-10">
                                {!! Form::textarea('reason', null, ['class'=>'form-control','v-model'=>'form.reason']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <a class="btn btn-primary" href="{{route('user_status',['cwruid'=>$currentUser->id])}}">View contract status</a>
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
