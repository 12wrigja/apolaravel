@extends('master_scrub')

@section('stylesheets')
<link rel="stylesheet" type="text/css" href="../packages/css/masthead_full.css">
@stop

@section('content')

<div class="ui two column grid">
	<div class="six wide column">
	<div class="ui">
		<img src="/packages/images/lock-image.png" class="ui medium image">
		</div>
	</div>
	<div class="ten wide column">
		<div class="ui">
			<h1 class="ui inverted header">We are sorry - you are unauthorized.</h1>
			@if(null != Session::get('username'))
				<p class="inverted">You have signed in with the username {{Session::get('username')}}.</p>
			@endif
			<p>{{$message or ""}}</p>
		</div>
	</div>
</div>

@stop