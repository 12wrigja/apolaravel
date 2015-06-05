@extends('contracts.base')

@section('crud_form')
    <h1>Create a new APO Contract</h1>

    {!! Form::open(['route'=>'contract_store']) !!}

    <div class="form-group">
        {!! Form::label('display_name','Name:') !!}
        {!! Form::text('display_name', null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Create Contract', ['class'=>'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@endsection