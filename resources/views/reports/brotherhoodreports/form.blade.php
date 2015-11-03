<div class="form-horizontal">
    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('event_name','Event Name') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            {!! Form::text('event_name', null, ['class'=>'form-control','v-model'=>'form.event_name']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('description','Description') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            {!! Form::textarea('description', null, ['class'=>'form-control','v-model'=>'form.description']) !!}
        </div>
    </div>
</div>

<div class="row form-row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-md-4 control-label">
                {!! Form::label('event_date','Date') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-md-8">
                {!! Form::input('date','event_date', null,
                ['class'=>'form-control','v-model'=>'form.event_date']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-md-4 control-label">
                {!! Form::label('location','Event Location') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-md-8">
                {!! Form::text('location', null, ['class'=>'form-control','v-model'=>'form.location']) !!}
            </div>
        </div>
    </div>
</div>

<div class="row form-row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-sm-4 control-label">
                {!! Form::label('type','Project Type') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-8">
                {!! Form::select('type', [
                'fellowship'=>'Fellowship Event',
                'pledge'=>'Pledge Meeting',
                'other'=>'Other'
                ],null, ['class'=>'form-control','v-model'=>'form.type']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">

    </div>
</div>

<div class="form-group">
    <h2>Brothers in Report</h2>

    <p name="brothers" class="help-block"></p>
    <td><select id="brotherselecter" placeholder="Search for a Brother..." class="form-control" style="width: 100%;"></select></td>
    <!-- Brothers listing -->
    <table class="table table-hover">
        <thead>
        <th class="col-md-9">Brother</th>
        <th class="col-md-1">Hours</th>
        <th class="col-md-1">Minutes</th>
        <th class="col-md-1"></th>
        </thead>
        <tbody>
        <tr v-repeat="brother: form.brothers">
            <td>@{{ brother.name }}</td>
            <td class="form-group">
                <div>{!! Form::text('brothers.@{{$index}}.hours', null, ['class'=>'form-control','v-model'=>'brother.hours']) !!}</div>
                <p class="help-block"></p>
            </td>
            <td class="form-group">
                <div>{!! Form::text('brothers.@{{$index}}.minutes', null, ['class'=>'form-control','v-model'=>'brother.minutes']) !!}</div>
                <p class="help-block"></p>
            </td>
            <td>
                <div class="btn btn-danger" v-on="click: removeBrother(brother)">Remove</div>
            </td>
        </tr>
        </tbody>
    </table>
</div>