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
                {!! Form::input('date','event_date', null, ['class'=>'form-control','v-model'=>'form.event_date']) !!}
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
                {!! Form::label('project_type','Project Type') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-8">
                {!! Form::select('project_type',['inside'=>'Inside','outside'=>'Outside'] ,null, ['class'=>'form-control','v-model'=>'form.project_type']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-sm-4 control-label">
                {!! Form::label('service_type','Type of Service') !!}
                <p class="help-block"></p>

            </div>
            <div class="col-sm-8">
                {!! Form::select('service_type', [
                'chapter'=>'Service to the Chapter',
                'campus'=>'Service to the Campus',
                'community'=>'Service to the Community',
                'country'=>'Service to the Country'
                ],null, ['class'=>'form-control','v-model'=>'form.service_type']) !!}
            </div>
        </div>
    </div>
</div>

<div class="row form-row" v-show="allowOffCampus" v-transition="expand">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-sm-4 control-label">
                {!! Form::label('off_campus','Off Campus') !!}
                <p class="help-block"></p></div>
            {{--<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>--}}
            <div class="col-sm-8">{!! Form::select('off_campus', ['0'=>'No','1'=>'Yes'], '0' ,['class'=>'form-control','v-model'=>'form.off_campus']) !!}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-sm-4 control-label">
                {!! Form::label('travel_time','Travel Time') !!}
                <p>(Minutes)</p>

                <p class="help-block"></p></div>
            {{--<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>--}}
            <div class="col-sm-8">{!! Form::text('travel_time', null, ['class'=>'form-control','v-model'=>'form.travel_time', 'v-attr'=>'disabled : allowTravelTime | not']) !!}</div>
        </div>
    </div>
</div>
<div class="form-group form-row">
    <h2>Brothers in Report</h2>
    <div class="form-group">
        <label for="brothers" class="help-block"></label>
        <select id="brotherselecter" placeholder="Search for a Brother..." class="form-control" style="width: 100%;"></select>
    </div>
    <!-- Brothers listing -->
    <table class="table table-hover">
        <thead>
        <th>Brother</th>
        <th>Hours</th>
        <th>Minutes</th>
        <th>Driver?</th>
        <th></th>
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
            <td>{!! Form::select('is_driver', ['0'=>'No','1'=>'Yes'], '0' ,['class'=>'form-control','v-model'=>'brother.is_driver']) !!}</td>
            <td>
                <div class="btn btn-danger" v-on="click: removeBrother(brother)">Remove</div>
            </td>
        </tr>
        </tbody>
    </table>
</div>