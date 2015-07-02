@extends('templates.crud_template')

@section('crud_form')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">APO Contracts</h1>
        </div>
    </div>

    <p>Displayed here are all of the contracts, both past and present, that the website understands. In order to create
        a new contract you must either be a web administrator, or the Membership VP. In order to delete a contract, you
        must be a web admin and understand the consequences of deleting the contract.</p>

    <table class="table table-hover">

        <thead>
        <th>
            Display Name
        </th>
        <th>
            Creation Time
        </th>
        <th>
            Last Changed
        </th>
        <th>
            <a href="{!! route('contract_create') !!}" role="button" class="btn btn-success">Create a new Contract</a>
        </th>
        </thead>
        <tbody>
        @foreach($contracts as $contract)
            <tr>
                <td>
                    <h2>
                        {{$contract->display_name}}
                    </h2>
                    <h4>Description: </h4><p>{{$contract->description}}</p>
                </td>
                <td>
                    {{$contract->created_at->diffForHumans()}}
                </td>
                <td>
                    {{$contract->updated_at->diffForHumans()}}
                </td>
                <td>
                    <a href="{!! route('contract_edit',$contract->id) !!}" role="button" class="btn btn-default">Edit
                        Contract</a>
                    <br><br/>
                    {!! Form::delete(route('contract_delete').$contract->id,'Delete this Contract',array(),array('class'=>'btn
                    btn-danger')) !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection