@extends('static_fullscreen')

@section('content')
Hello, Test!
@foreach ($ids as $id)
    <div class="ui button">{{$id or 'Null'}}</div>
@endforeach
@stop