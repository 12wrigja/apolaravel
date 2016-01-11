@extends('templates.crud_template')

@section('crud_form')

    <h1>Pledge Management Tool</h1>
    <p> Use these tools below to manage pledges on the website. Any questions should be directed to the webmaster.</p>
    <div class="alert alert-danger alert-important" role="alert">
        <h3 class="text-center">Under Development!</h3>
        <p>This page is currently under development. Editing of Pledge's Bigs and Families is not working, and may cause unexpected errors.</p>
    </div>
    <pledge-manager inline-template>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#pledgelist" aria-controls="pledgelist" role="tab"
                                                          data-toggle="tab">All Pledges</a>
                </li>
                <li role="presentation"><a href="#createPledge" aria-controls="createPledge" role="tab"
                                           data-toggle="tab">Create Pledge</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="pledgelist">
                    <div v-repeat="pledge : pledges.data">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading@{{pledge.id}}">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapse@{{pledge.id}}" aria-expanded="false"
                                       aria-controls="collapse@{{pledge.id}}">
                                        @{{pledge.display_name}} (@{{pledge.id}})
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse@{{pledge.id}}" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="heading@{{pledge.id}}">
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <h4>First Name</h4>

                                        <p>@{{ pledge.first_name }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>Last Name</h4>

                                        <p>@{{ pledge.last_name }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>CWRU ID</h4>

                                        <p>@{{ pledge.id }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>Big</h4>

                                        <p>@{{ pledge.big.display_name | pnull}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>Family</h4>

                                        <p>@{{ pledge.family.name | pnull}}</p>
                                    </div>
                                    <div class="btn btn-primary" v-on="click: editPledge(pledge)">Edit</div>
                                    <div class="btn btn-success" v-on="click: initiatePledge(pledge)">Initiate</div>
                                    <div class="btn btn-danger" v-on="click: deletePledge(pledge)">Delete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav v-show="showReportPagination">
                        <ul class="pager">
                            <li class="previous"
                                v-show="showReportPagination && reports.meta.pagination.links.previous"><a class="btn"
                                                                                                           v-on="click: getPage(reports_page+1,false)"><span
                                            aria-hidden="true">&larr;</span> Older</a></li>
                            <li class="next" v-show="showReportPagination && reports.meta.pagination.links.next"><a
                                        class="btn" v-on="click: getPage(reports_page-1,false)">Newer <span
                                            aria-hidden="true">&rarr;</span></a></li>
                        </ul>
                    </nav>
                </div>
                <div role="tabpanel" class="tab-pane" id="createPledge">
                    @include('users.create')
                </div>
            </div>
        </div>
        <form_editor inline-template v-ref="editForm">
            <div class="modal fade" v-el="modal">
                <div class="modal-dialog modal-wide">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Pledge</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['route'=>['user_update','id'=>':id'],'class'=>'collapse in','v-el'=>'iform'])!!}
                            <div class="row form-row">
                                <div class="col-sm-3">
                                    <h4>CWRU ID
                                        <small>uneditable</small>
                                    </h4>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-left">@{{ form.id }}</p>
                                </div>

                            </div>
                            <div class="row form-row">
                                <div class="form-group">
                                    <div class="col-sm-2 control-label">
                                        {!! Form::label('first_name','First Name') !!}
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="col-sm-10">
                                        {!! Form::text('first_name', null, ['class'=>'form-control','v-model'=>'form.first_name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row form-row">
                                <div class="form-group">
                                    <div class="col-sm-2 control-label">
                                        {!! Form::label('last_name','Last Name') !!}
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="col-sm-10">
                                        {!! Form::text('last_name', null, ['class'=>'form-control','v-model'=>'form.last_name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row form-row">
                                <div class="form-group">
                                    <div class="col-sm-2 control-label">
                                        {!! Form::label('big','Big') !!}
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="col-sm-10">
                                        <single-brother-selector brother="@{{ form.big.id }}"></single-brother-selector>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-row">
                                <div class="form-group">
                                    <div class="col-sm-2 control-label">
                                        {!! Form::label('family_id','Family') !!}
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="col-sm-10">
                                        {!! Form::text('family_id', null, ['class'=>'form-control','v-model'=>'form.family_id']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
                            <h3 class="text-center">Editing Pledge...</h3>

                            <div class="progress">
                                <div class="progress-bar  progress-bar-striped active" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" v-on="click: submitForm(event)">Save changes
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </form_editor>
    </pledge-manager>
@endsection