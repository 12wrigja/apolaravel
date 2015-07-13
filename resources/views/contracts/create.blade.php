@extends('templates.crud_template')

@section('metadata')
    <meta name="requirement_url" content="{!! route('contractreq_view')!!}">
    <meta name="contract_index_url" content="{!! route('contract_view') !!}">
    <meta name="requirement_create_url" content="{!! route('contractreq_store') !!}">
@endsection

@section('crud_form')

    <h1 class="page-header">Create a new APO Contract</h1>

    <contract-create-form inline-template>

        {!! Form::open(['route'=>'contract_store','class'=>'collapse in','v-el'=>'iform']) !!}

        <div class="form-group">

            {!! Form::label('display_name','Display Name:') !!}
            <p class="help-block"></p>
            {!! Form::text('display_name', null, ['class'=>'form-control','v-model'=>'form.display_name']) !!}
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
        </div>

        <div class="form-group">
            {!! Form::label('description','Description:') !!}
            <p class="help-block"></p>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            {!! Form::textarea('description', null, ['class'=>'form-control','v-model'=>'form.description']) !!}
        </div>

        <div class="form-group">
            <h2>Requirements</h2>

            <p class="help-block"></p>

            <div>
                <button class="btn btn-success" type="button" id="reqCreate" data-toggle="modal"
                        data-target="#createRequirement">Create a new Requirement
                </button>
                <button class="btn btn-primary" type="button" data-toggle="modal"
                        data-target="#existingRequirements">Link an Existing Requirement
                </button>
            </div>
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
                <tbody>
                <tr v-repeat="requirement: form.requirements">
                    <td>
                        @{{ requirement.display_name }}
                    </td>
                    <td>
                        @{{ requirement.description }}
                    </td>
                    <td>
                        @{{ requirement.comparison | prettyComparison}}
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

        @include('contracts.requirements.partials.create_requirement_modal')
        @include('contracts.requirements.partials.existing_requirements_modal')

    </contract-create-form>

@endsection