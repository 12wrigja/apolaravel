@extends('static_fullscreen')

@section('scripts')
<script type="text/javascript" src="/packages/javascript/createUser.js"></script>
@stop

@section('masthead')
<a class="ui button" href="{{URL::to('users/create')}}">Create a user</a>
<a class="ui button" href="{{URL::to('users')}}">View all users</a>
@if($errors->all() != null)
<div id="errorMessage" class="ui message">
	<div class="header">
		Errors:
	</div>
	 {{HTML::ul($errors->all(), array('class'=>'list'))}} 
</div>
@endif

</br>
</br>
{{Form::model(null,array('url' => array('users'), 'class'=>'ui form'))}}
	<!-- first name -->
	
        {{ Form::label('firstName', 'First Name') }}
    	<div class="field">    
        {{ Form::text('firstName') }}
		</div>
		
        <!-- last name -->
        {{ Form::label('lastName', 'Last Name') }}
        <div class="field">
        {{ Form::text('lastName') }}      
		</div>
		
		<!-- case id -->
        {{ Form::label('cwruID', 'Case ID') }}
        <div class="field">
        {{ Form::text('cwruID') }}
        </div>
        
        <!-- status -->
        {{ Form::label('status', 'Status') }}
        <!-- {{ Form::select('status',$statuses)}} -->
        {{ Form::dropdown('status',$statuses)}}
        {{ Form::submit('Create User', array('class'=>'ui submit button')) }}

{{Form::close()}}

@stop