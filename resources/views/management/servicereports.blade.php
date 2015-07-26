@extends('templates.crud_template')


@section('crud_form')
    <manage-service-reports-view inline-template>
        <h1>Manage Service Reports</h1>

        <p>Below is the service report management tool. Here you can view all submitted service reports and approve or
            un-approve as necessary.</p>

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#newReports">New Reports</a></li>
            <li><a data-toggle="tab" href="#approvedReports">Approved Reports</a></li>
        </ul>
        <div class="tab-content">
            <div id="newReports" class="tab-pane fade in active">
                <div v-show="reports | empty">
                    <h4>There are no new service reports to display at this time!</h4>
                </div>
                <div v-repeat="report : reports">
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
                                <h4>Description</h4>

                                <p>@{{report.description}}</p>

                                <h4>Location</h4>

                                <p>@{{report.location}}</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Project Type</h4>

                                        <p>@{{report.project_type}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>Service Type</h4>

                                        <p>@{{report.service_type}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Off Campus</h4>

                                        <p>@{{report.off_campus}}</p>
                                    </div>
                                    <div class="col-sm-6">

                                        <h4>Travel Time</h4>

                                        <p>@{{report.travel_time}} minutes</p>
                                    </div>
                                </div>


                                <br>

                                <div class="btn btn-primary" v-on="click: approveReport(report)">Approve</div>
                                <div class="btn btn-danger" v-on="click: deleteReport(report)">Delete</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="approvedReports" class="tab-pane fade">
                <div v-show="approved | empty">
                    <h4>There are no approved service reports to display at this time!</h4>
                </div>
                <div v-repeat="report : approved">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading@{{report.id}}">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse@{{report.id}}" aria-expanded="false"
                                   aria-controls="collapse@{{report.id}}">
                                    @{{ report.display_name }}
                                    @{{ report.event_date }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse@{{report.id}}" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="heading@{{report.id}}">
                            <div class="panel-body">
                                <h4>Description</h4>

                                <p>@{{report.description}}</p>

                                <h4>Location</h4>

                                <p>@{{report.location}}</p>

                                <h4>Project Type</h4>

                                <p>@{{report.project_type}}</p>

                                <h4>Service Type</h4>

                                <p>@{{report.service_type}}</p>

                                <h4>Off Campus</h4>

                                <p>@{{report.off_campus}}</p>

                                <h4>Travel Time</h4>

                                <p>@{{report.travel_time}} minutes</p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="dropdown1" class="tab-pane fade">
                    <h3>Dropdown 1</h3>

                    <p>WInteger convallis, nulla in sollicitudin placerat, ligula enim auctor lectus, in mollis diam
                        dolor
                        at
                        lorem. Sed bibendum nibh sit amet dictum feugiat. Vivamus arcu sem, cursus a feugiat ut, iaculis
                        at
                        erat. Donec vehicula at ligula vitae venenatis. Sed nunc nulla, vehicula non porttitor in,
                        pharetra
                        et
                        dolor. Fusce nec velit velit. Pellentesque consectetur eros.</p>
                </div>
                <div id="dropdown2" class="tab-pane fade">
                    <h3>Dropdown 2</h3>

                    <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit.
                        Donec
                        at
                        erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum
                        laoreet.
                        Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in
                        tempus
                        imperdiet. Cum sociis natoque penatibus et magnis.</p>
                </div>
            </div>
        </div>
    </manage-service-reports-view>
@endsection