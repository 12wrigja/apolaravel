@extends('templates.crud_template')

@section('metadata')
    <meta name="requirement_url" content="{!! route('contractreq_view')!!}">
    <meta name="contract_index_url" content="{!! route('contract_view') !!}">
    <meta name="requirement_create_url" content="{!! route('contractreq_store') !!}">
@endsection

@section('scripts')
    @parent
    {!! Html::script('js/contract/create.js') !!}
@endsection

@section('crud_form')



    <h1 class="page-header">Create a new APO Contract</h1>

    <contract-create-form inline-template>
        {!! Form::open(['route'=>'contract_store','v-on'=>'submit:
        submitForm()','id'=>'create_contract_form','class'=>'collapse in']) !!}

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
                @include('contracts.requirements.partials.create_requirement_modal')
                @include('contracts.requirements.partials.existing_requirements_modal')
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
                <tbody class="hidden">
                <tr v-repeat="requirement: form.requirements | orderBy 'display_name'">
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
                        <button class="btn btn-danger" type="button">Remove
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            {!! Form::submit('Create Contract', ['class'=>'btn btn-primary form-control']) !!}
        </div>

        <pre v-show="debug"> @{{form | json}} </pre>

        {!! Form::close() !!}

        <div id="loadingArea" class="alert alert-info alert-important collapse" role="alert">
            <h3 class="text-center">Creating Contract...</h3>

            <div class="progress">
                <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100"
                     aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
            </div>
        </div>
    </contract-create-form>

@endsection