@extends('static_fullscreen')

@section('masthead')
@if (Session::has('message'))
    <div class="ui message">
    	<div class="header">
    {{ Session::get('message') }}
    </div>
</div>
@endif
<a class="ui button" href="{{URL::to('users/create')}}">Create a user</a>
<a class="ui button" href="{{URL::to('users')}}">View all users</a>
<div class="ui divider"></div>
{{$users->links()}}
{{Form::open(array('url'=>'/users/search', 'class'=>'ui form'))}}
<div class='field'>
{{Form::text('query')}}
</div>
{{Form::submit('Search',array('class'=>'ui button')) }}
{{Form::close()}}
<table class="ui inverted table">
<thead>
<th>First Name</th>
<th>Last Name</th>
<th>CWRU ID</th>
<th>Status</th>
<th></th>
<th></th>
<th></th>
</thead>
<tbody>
@foreach($users as $key=>$value)
<tr>
	<td>{{$value -> firstName}}</td>
	<td>{{$value -> lastName}}</td>
	<td>{{$value -> cwruID}}</td>
	<td>{{$value -> getStatus()-> status or 'None'}}</td>
	
	<td><a class="ui button" href="{{URL::to('/nerds/' .$value -> id )}}">View Profile</a></td>
	<td><a class="ui button" href="{{URL::to('/nerds/' .$value -> id . '/edit')}}">Edit User</a></td>
	<td>{{ Form::open(array('url' => '/users/'.$value->cwruID)) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete User', array('class' => 'ui button red')) }}
                {{ Form::close() }}</td>
</tr>
@endforeach
</tbody>
</table>
{{$users->links()}}
@stop