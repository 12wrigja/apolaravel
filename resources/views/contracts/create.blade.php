@extends('contracts.base')

@section('scripts')
    @parent
    {!! Html::script('js/contract_create.js') !!}
@endsection

@section('metadata')
    <meta name="requirement_url" content="{!! route('contractreq_view')!!}">
    <meta name="contract_index_url" content="{!! route('contract_view') !!}">
@endsection

@section('crud_form')

    @include('contracts.partials.existing_requirements_modal')
    @include('contracts.partials.create_requirement_modal')
    <h1>Create a new APO Contract</h1>

    {!! Form::open(['route'=>'contract_store','v-on'=>'submit: createContract','id'=>'create_contract_form','class'=>'collapse in']) !!}

    <div class="form-group">
        {!! Form::label('display_name','Display Name:') !!}
        {!! Form::text('display_name', null, ['class'=>'form-control','v-model'=>'contract.display_name']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description','Description:') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control','v-model'=>'contract.description']) !!}
    </div>

    <h2>Requirements</h2>
    <div class="form-group">
        <p>
            <button class="btn btn-success" type="button" id="reqCreate" data-toggle="modal"
                    data-target="#createRequirement">Create a new Requirement
            </button>
            <button class="btn btn-info" type="button" id="reqPick" data-toggle="modal"
                    data-target="#existingRequirements">Link an Existing Requirement
            </button>
        </p>


        <table class="table table-hover">
            <thead>
            <th>
                Requirement Name
            </th>
            <th>
                Description
            </th>
            <th>
                Success Comparison Type
            </th>
            <th>
                Threshold
            </th>
            <th>

            </th>
            </thead>
            <tbody class="hidden">
            <tr v-repeat="requirement: contract.requirements | orderBy 'display_name'">
                <td>
                    @{{ requirement.display_name }}
                </td>
                <td>
                    @{{ requirement.description }}
                </td>
                <td>
                    @{{ requirement.comparison | prettyComparison }}
                </td>
                <td>
                    @{{ requirement.threshold }}
                </td>
                <td>
                    <button class="btn btn-danger" type="button" v-on="click: removeRequirement(requirement)">Remove
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="form-group">
        {!! Form::submit('Create Contract', ['class'=>'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

    <div id="loadingArea" class="alert alert-info collapse" role="alert">
        <h3 class="text-center">Creating Contract...</h3>
        <div class="progress">
            <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
        </div>
    </div>

    <div id="completeArea" class="collapse">
        <h2 class=""></h2>
    </div>

@endsection