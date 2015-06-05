@extends('contracts.base')

@section('crud_form')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">APO Contracts</h1>
        </div>
    </div>



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

                    <h3>
                        Requirements:
                    </h3>

                    <p>Requirements go here!</p>
                </td>
                <td>
                    {{$contract->created_at}}
                </td>
                <td>
                    {{$contract->updated_at}}
                </td>
                <td>
                    {!! Form::delete('contracts/'.$contract->id,'Delete this Contract',array(),array('class'=>'btn btn-danger')) !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection