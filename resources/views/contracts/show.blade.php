@extends('templates.crud_template')

@section('crud_form')

    <h1 class="page-header">{{ $contract->display_name }}</h1>

    <label>Description</label>
    <p>{{$contract->description}}</p>

        <h2>Requirements</h2>

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
            </thead>
            <tbody>
            @foreach($contract->requirements as $requirement)
            <tr>
                <td>
                    {{ $requirement->display_name }}
                </td>
                <td>
                    {{ $requirement->description }}
                </td>
                <td>
                    {{ $requirement->prettyComparison() }}
                </td>
                <td>
                    {{ $requirement->threshold }}
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection