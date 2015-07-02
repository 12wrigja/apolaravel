@extends('templates.crud_template')

@section('scripts')
    {!! Html::script('js/helpers.js') !!}
    {!! Html::script('js/comparisons.js') !!}
    {!! Html::script('js/contracts/requirements/create.js') !!}
@endsection

@section('crud_form')

    <h1 class="'page-header">Edit {{ $requirement->display_name }}</h1>
    {!! Form::model($requirement,['route'=>'contractreq_store','v-on'=>'submit: createRequirement($event)','id'=>'create_requirement_form']) !!}
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
        {!! Form::label('threshold','Threshold') !!}
        {!! Form::text('threshold', null, ['class'=>'form-control','v-model'=>'create_form.threshold
        ','number']) !!}
    </div>

    <div class="form-group">
        <h2>Event Filters</h2>
        <p class="help-block"></p>
        <p>
            <button class="btn btn-info" type="button" v-on="click: createFilter">Create New Filter
            </button>
        </p>


        <table class="table table-hover">
            <thead>
            <th>
                Display Name
            </th>
            <th>
                Controller
            </th>
            <th>
                Method
            </th>
            <th>

            </th>
            </thead>
            <tbody class="">
            <tr v-repeat="filter: create_form.filters | orderBy 'execution_order'">
                <td>
                    {!! Form::text('Threshold', null, ['class'=>'form-control','v-model'=>'filter.description
                    ']) !!}
                </td>
                <td>
                    {!! Form::text('Threshold', null, ['class'=>'form-control','v-model'=>'filter.controller
                    ']) !!}
                </td>
                <td>
                    {!! Form::text('Threshold', null, ['class'=>'form-control','v-model'=>'filter.method
                    ']) !!}
                </td>
                <td>
                    <button class="btn btn-danger" type="button" v-on="click: removeFilter(filter)">Remove
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="form-group">
        {!! Form::submit('Update Contract Requirement', ['class'=>'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

    <pre>@{{create_form | json}}</pre>

@endsection