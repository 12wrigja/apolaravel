@extends('static_fullscreen')

@section('masthead')
<div class="ui two column stackable grid">
	<div class="six wide column">
		<img src="{{$user->pictureURL(700)}}" class="ui image">
	</div>
	<div class="ten wide column">
		<div class="ui">
			<h1 class="ui inverted header">{{$user->firstName}} {{$user->lastName}}</h1>
			<p class="ui inverted">Status: {{$user->status()->first()->status}}</p>
			<p class="ui inverted">Pledged {{HTML::semToText($user->pledgeSem)}}</p>
			<p class="ui inverted">Initiation Semester: {{HTML::semToText($user->InitSem)}}</p>
		</div>
	</div>
</div>
@stop

@section('content')
<div class="ui page grid segment">
<div class="column">
<h3>About Me:</h3>
<p>{{$user->bio}}
<h3></h3>
</div>
</div>
@stop