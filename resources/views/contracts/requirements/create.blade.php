@extends('templates.crud_template')

@section('scripts')
    {!! Html::script('js/helpers.js') !!}
    {!! Html::script('js/comparisons.js') !!}
    {!! Html::script('js/contracts/requirements/contractreq_create.js') !!}
@endsection

@section('crud_form')

    <h1 class="'page-header">Create a new Contract Requirement</h1>
    {!! Form::open(['route'=>'contractreq_store','v-on'=>'submit: createRequirement($event)','id'=>'create_requirement_form']) !!}
    <div class="form-group">
        {!! Form::label('display_name','Display Name') !!}
        {!! Form::text('display_name', null,
        ['class'=>'form-control','v-model'=>'create_form.display_name']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description','Description') !!}
        {!! Form::textarea('description', null,
        ['class'=>'form-control','v-model'=>'create_form.description']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('comparison','Threshold Comparison:') !!}
        {!! Form::select('comparison',[
        'LT'=>'Less Than',
        'LEQ'=>'Less Than or Equal To',
        'EQ'=>'Equal To',
        'GEQ'=>'Greater Than or Equal To',
        'GT'=>'Greater Than'], 'GEQ' ,['class'=>'form-control','v-model'=>'create_form.comparison']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Threshold','Threshold') !!}
        {!! Form::text('Threshold', null, ['class'=>'form-control','v-model'=>'create_form.threshold
        ','number']) !!}
    </div>

    <div class="form-group">
        <h2>Satisfying Events</h2>
        <p class="help-block"></p>
        <p>
            <button class="btn btn-info" type="button" id="reqPick" data-toggle="modal"
                    data-target="#existingEvent">Link an Existing Event Type
            </button>
        </p>


        <table class="table table-hover">
            <thead>
            <th>
                Event Name
            </th>
            <th>
                Description
            </th>
            <th>

            </th>
            </thead>
            <tbody class="hidden">
            <tr v-repeat="contract_event: requirement.contract_events | orderBy 'display_name'">
                <td>
                    @{{ requirement.display_name }}
                </td>
                <td>
                    @{{ requirement.description }}
                </td>
                <td>
                    <button class="btn btn-danger" type="button" v-on="click: removeContractEvent(requirement)">Remove
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="form-group">
        {!! Form::submit('Create Contract Requirement', ['class'=>'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

    <pre class="debug-block">@{{create_form | contractCreate | json}}</pre>

@endsection