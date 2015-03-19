@extends('static_fullscreen')

@section('masthead')
<h2>Profile Editor</h2>
{{Form::model($user,array('route'=>array('users.update',$user->cwruID),'method'=>'PUT','class'=>'ui form'))}}

		{{Form::label('CWRU ID')}}
		<div class='field'>
		{{Form::text('cwruID')}}
		</div>
	
		{{Form::label('First Name')}}
		<div class='field'>
		{{Form::text('firstName')}}
		</div>
		
		{{Form::label('Last Name')}}
		<div class='field'>
		{{Form::text('lastName')}}
		</div>
		
		{{Form::label('Last Name')}}
		<div class='field'>
		{{Form::text('lastName')}}
		</div>
		
		{{Form::label('Last Name')}}
		<div class='field'>
		{{Form::text('lastName')}}
		</div>
		
		{{Form::label('Last Name')}}
		<div class='field'>
		{{Form::text('lastName')}}
		</div>
		
		{{Form::label('Last Name')}}
		<div class='field'>
		{{Form::text('lastName')}}
		</div>
{{Form::close()}}
@stop