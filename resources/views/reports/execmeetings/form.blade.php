<div class="form-horizontal">

    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('event_date','Date') !!}
            <p class="help-block"></p>
            {{--<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>--}}
        </div>
        <div class="col-sm-10">
            {!! Form::input('date','event_date', null,
            ['class'=>'form-control','v-model'=>'form.event_date']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('description','Minutes') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            {!! Form::textarea('description', null, ['class'=>'form-control','v-model'=>'form.description']) !!}
        </div>
        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
    </div>
</div>

<div class="form-horizontal">
    <h2>Brothers at Meeting</h2>

    <p class="help-block"></p>
    <td><select id="brotherselecter" placeholder="Search for a Brother..." class="form-control" style="width:100%"></select></td>
    <!-- Brothers listing -->
    <table class="table table-hover">
        <thead>
        <th>Brother</th>
        <th>Count For</th>
        <th></th>
        </thead>
        <tbody>
        <tr v-repeat="brother: form.brothers">
            <td>@{{ brother.name }}</td>
            <td>
            {!! Form::select('count_for', ['chapter'=>'Chapter','pledge'=>'Pledge','exec'=>'Exec'], 'exec' ,['class'=>'form-control','v-model'=>'brother.count_for']) !!}
            <td>
                <div class="btn btn-danger" v-on="click: removeBrother(brother)">Remove</div>
            </td>
        </tr>
        </tbody>
    </table>