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
            {!! Form::label('minutes','Minutes') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#minutesedit" aria-controls="minutesedit" role="tab"
                                                              data-toggle="tab">Edit</a></li>
                    <li role="presentation"><a href="#minutesshow" aria-controls="minutesshow" role="tab"
                                               data-toggle="tab">Preview</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="minutesedit">
                        <vue-html-editor model="@{{@ form.minutes}}"></vue-html-editor>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="minutesshow" style="height:300px; overflow:scroll;">
                        @{{{ form.minutes }}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-horizontal">
    <div class="form-group">
        <h2>Brothers at Meeting</h2>

        <p class="help-block" for="brothers"></p>
        <td><select id="brotherselecter" placeholder="Search for a Brother..." class="form-control"
                    style="width: 100%;"></select></td>
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
                {!! Form::select('count_for', ['chapter'=>'Chapter','pledge'=>'Pledge','exec'=>'Exec'], 'pledge' ,['class'=>'form-control','v-model'=>'brother.count_for']) !!}
                <td>
                <td>
                    <div class="btn btn-danger" v-on="click: removeBrother(brother)">Remove</div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>