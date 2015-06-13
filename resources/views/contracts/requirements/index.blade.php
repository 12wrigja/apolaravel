@extends('templates.crud_template')

@section('scripts')
    @parent
    {!! Html::script('js/comparisons.js') !!}
@endsection

@section('crud_form')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">APO Contract Requirements</h1>
        </div>
    </div>

    <p>Displayed here are all of the contract requirements, both past and present, that have been used in contracts.</p>
    <p>Contract requirements will automatically be deleted when no contract is linked to them any more. This is triggered upon deletion of the last contract that was linked to the requirement.</p>

    <table class="table table-hover">

        <thead>
        <th>
            Display Name
        </th>
        <th>
            Description
        </th>
        <th>
            Comparison
        </th>
        <th>
            Requirement Threshold
        </th>
        <th>
            <a href="{!! route('contractreq_create') !!}" role="button" class="btn btn-success">Create a new Contract</a>
        </th>
        </thead>
        <tbody>
        @foreach($contractReqs as $contractReq)
            <tr>
                <td>
                    <h4>
                        {{$contractReq->display_name}}
                    </h4>
                </td>
                <td>
                    {{ $contractReq->description }}
                </td>
                <td>
                    {{ $contractReq->prettyComparison() }}
                </td>
                <td>
                    {{ $contractReq -> threshold }}
                </td>
                <td>
                    <a href="{!! route('contractreq_edit',$contractReq->id) !!}" role="button" class="btn btn-default">Edit
                        Requirement</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection