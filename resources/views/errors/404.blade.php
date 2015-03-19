@extends('home')

@section('stylesheets')
<link rel="stylesheet" type="text/css" href="../packages/css/masthead_full.css">
@stop

@section('masthead')

<div class="ui two column grid">
	<div class="six wide column">
	<div class="ui">
		<img src="../packages/images/torch-logo.png" class="ui medium image">
		</div>
	</div>
	<div class="ten wide column">
		<div class="ui">
			<h1 class="ui inverted header">We can't find it!</h1>
			<p class="inverted">We are sorry - whatever you were looking for cannot be found.</p>
		</div>
	</div>
</div>

@stop

@section('content')
@stop