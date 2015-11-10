<div class="row">

    <div class="col-sm-6">
        <h4>Event Name</h4>

        <p>@{{ report.event_name }}</p>
    </div>
    <div class="col-sm-6">
        <h4>Submitter</h4>

        <p>@{{report.submitter.display_name}}</p>
    </div>
</div>

<h4>Description</h4>

<P>@{{ report.description }}</P>

<div class="row">

    <div class="col-sm-6">
        <h4>Event Date</h4>

        <p>@{{ report.human_date }}</p>
    </div>
    <div class="col-sm-6">
        <h4>Location</h4>

        <p>@{{report.location}}</p>
    </div>
</div>

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

<h4>Brothers</h4>

<table class="table table-hover">
    <thead>
    <th>Brother</th>
    <th>CWRU ID</th>
    <th>Hours</th>
    <th>Minutes</th>

    </thead>
    <tbody>
    <tr v-repeat="brother: report.brothers">
        <td>@{{ brother.name }}</td>
        <td>@{{ brother.id }}</td>
        <td>@{{ brother.hours }}</td>
        <td>@{{ brother.minutes }}</td>
    </tr>
    </tbody>
</table>


<br>
