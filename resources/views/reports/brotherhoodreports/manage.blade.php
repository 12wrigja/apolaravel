@extends('templates.crud_template')


@section('crud_form')
    <manage-brotherhood-reports-view inline-template>
        <h1>Manage Brotherhood Reports</h1>

        <p>Below is the brotherhood report management tool. Here you can view all submitted service reports and approve or
            un-approve as necessary.</p>

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#newReports">New Reports</a></li>
            <li><a data-toggle="tab" href="#approvedReports">Approved Reports</a></li>
        </ul>
        <div class="tab-content">
            <div id="newReports" class="tab-pane fade in active">
                <div v-show="reports.data | empty">
                    <h4>There are no new service reports to display at this time!</h4>
                </div>
                <div v-repeat="report : reports.data">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading@{{report.id}}">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse@{{report.id}}" aria-expanded="false"
                                   aria-controls="collapse@{{report.id}}">
                                    @{{report.display_name}}
                                    @{{report.date}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse@{{report.id}}" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="heading@{{report.id}}">
                            <div class="panel-body">
                                @include('reports.servicereports.report_details')
                                <div class="btn btn-primary" v-on="click: approveReport(report)">Approve</div>
                                <div class="btn btn-danger" v-on="click: deleteReport(report)">Delete</div>
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
            <div id="approvedReports" class="tab-pane fade">
                <div v-show="approved.data | empty">
                    <h4>There are no approved service reports to display at this time!</h4>
                </div>
                <div v-repeat="report : approved.data">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading@{{report.id}}">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse@{{report.id}}" aria-expanded="false"
                                   aria-controls="collapse@{{report.id}}">
                                    @{{report.display_name}}
                                    @{{report.date}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse@{{report.id}}" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="heading@{{report.id}}">
                            <div class="panel-body">

                                @include('reports.servicereports.report_details')

                            </div>
                        </div>
                    </div>
                </div>
                <nav v-show="showApprovedPagination">
                    <ul class="pager">
                        <li class="previous" v-show="showApprovedPagination"><a class="btn" v-on="click: getPage(approved_page+1,true)"><span aria-hidden="true">&larr;</span> Older</a></li>
                        <li class="next" v-show="showApprovedPagination"><a class="btn" v-on="click: getPage(approved_page-1,true)">Newer <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </manage-brotherhood-reports-view>
@endsection