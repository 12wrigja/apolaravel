@extends('templates.crud_template')

@section('crud_form')

    <h1>Pledge Management Tool</h1>
    <p> Use for tools below to manage pledges on the website. Any questions should be directed to the webmaster.</p>
    <pledge-manager>
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
                                        @{{pledge.display_name}} | (@{{pledge.id}})
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse@{{pledge.id}}" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="heading@{{pledge.id}}">
                                <div class="panel-body">

                                </div>
                            </div>
                        </div>
                    </div>
                    <nav v-show="showReportPagination">
                        <ul class="pager">
                            <li class="previous" v-show="showReportPagination && reports.meta.pagination.links.previous"><a class="btn" v-on="click: getPage(reports_page+1,false)"><span aria-hidden="true">&larr;</span> Older</a></li>
                            <li class="next" v-show="showReportPagination && reports.meta.pagination.links.next"><a class="btn" v-on="click: getPage(reports_page-1,false)">Newer <span aria-hidden="true">&rarr;</span></a></li>
                        </ul>
                    </nav>
                </div>
                <div role="tabpanel" class="tab-pane" id="createPledge">
                    @include('users.create')
                </div>
            </div>
        </div>
    </pledge-manager>
@endsection