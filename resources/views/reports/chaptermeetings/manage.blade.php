@extends('templates.crud_template')


@section('crud_form')
    <manage_chapter_meetings_form inline-template>
        <h1>Manage Chapter Meetings</h1>

        <p>Below is the chapter meeting management tool. This can be used to modify the stored minutes or present
            chapter members at a chapter meeting.</p>

        <div v-show="reports.data | empty">
            <h4>There are no meetings to display at this time!</h4>
        </div>
        <div v-repeat="report : reports.data | orderBy 'date' -1">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading@{{report.id}}">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse@{{report.id}}" aria-expanded="false"
                           aria-controls="collapse@{{report.id}}">
                            Chapter Meeting
                            @{{report.human_date}}
                        </a>
                    </h4>
                </div>
                <div id="collapse@{{report.id}}" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="heading@{{report.id}}">
                    <div class="panel-body">
                        @include('reports.chaptermeetings.report_details')
                        {{--<div class="btn btn-primary" v-on="click: editReport(report)">Edit</div>--}}
                    </div>
                </div>
            </div>
        </div>
        <nav v-show="showReportPagination">
            <ul class="pager">
                <li class="previous" v-show="showReportPagination && reports.meta.pagination.links.next"><a
                            class="btn" v-on="click: getPage(reports_page+1,false)"><span
                                aria-hidden="true">&larr;</span> Older</a></li>
                <li class="next" v-show="showReportPagination && reports.meta.pagination.links.previous"><a
                            class="btn" v-on="click: getPage(reports_page-1,false)">Newer <span
                                aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>

        <form_editor inline-template v-ref="editForm">
            <div class="modal fade" v-el="modal">
                <div class="modal-dialog modal-wide">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Service Report</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['route'=>['report_update','type'=>'chapter_meetings','id'=>':id'],'class'=>'collapse in','v-el'=>'iform'])!!}
                            @include('reports.chaptermeetings.form')
                            {!! Form::close() !!}
                        </div>
                        <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
                            <h3 class="text-center">Editing Report...</h3>

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
    </manage_chapter_meetings_form>
@endsection