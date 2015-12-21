<div class="row">

    <div class="col-sm-6">
        <h4>Meeting Date</h4>

        <p>@{{ report.human_date }}</p>
    </div>
    <div class="col-sm-6">
        <h4>Submitter</h4>

        <p>@{{report.submitter.display_name}}</p>
    </div>
</div>

<h4>Minutes</h4>

<p>@{{{report.minutes}}}</p>

<h4>Brothers</h4>

<table class="table table-hover">
    <thead>
    <th>Brother</th>
    <th>CWRU ID</th>
    <th>Count For</th>

    </thead>
    <tbody>
    <tr v-repeat="brother: report.brothers">
        <td>@{{ brother.name }}</td>
        <td>@{{ brother.id }}</td>
        <td>@{{ brother.count_for }}</td>
    </tr>
    </tbody>
</table>


<br>
