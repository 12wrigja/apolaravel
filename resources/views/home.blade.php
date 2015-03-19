@extends('master') 

@section('stylesheets')
@if(Session::get('username') === 'jsk137')
<link rel="stylesheet" type="text/css"
	href="../packages/css/jsk137.css">
@endif
@stop

@section('left_menu_items')
<a class="item" href="/">Home</a>
<a class="item" href="/">About APO</a>
<div class="ui dropdown link item">
	Our Chapter 
	<i class="dropdown icon"></i>
	<div class="menu">
		<a class="item">Chapter Officers</a>
		 <a class="item">Past Officers</a> 
		 <a class="item" href="{{URL::to('users')}}">Chapter Members</a>
			<a class="item">Alumni Information</a>
			<a class="item">Alumni Newsletter</a>
			<a class="item">Theta Upsilon Traditions</a>
			<a class="item">Chapter History</a>
	</div>
</div>
<a class="item" href="">Joining APO</a>
@stop

@section('masthead')
<div class="ui two column stackable grid">
	<div class="six wide centered column">
		<img src="../packages/images/torch-logo.png" class="ui medium image">
	</div>
	<div class="ten wide column">
		<div class="ui">
			<h1 class="ui inverted header">Welcome to APO - Theta Upsilon!</h1>
			<p class="inverted">Awesome APO tagline here!</p>
			<div class="large basic inverted ui button">
				<div class="visible content">Learn More!</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('content')
<div class="ui page grid overview segment">
	<h2 class="ui header center">What is APO all about?</h2>
    <div class="ui two wide column"></div>
    <div class="twelve wide column">
      <div class="ui three column center aligned stackable divided grid">
        <div class="column">
          <div class="ui icon header">
            <img class="ui image small link" src="../packages/images/leadership-image.png"></img>
            Leadership 
          </div>
          <p>Through LEADS courses and various executive positions, APO provides many opportunities to enhance your leadership skills.</p>
          <p><a class="ui teal right labeled icon button" href="#">Lead <i class="right chevron icon"></i></a></p>
        </div>
        <div class="column">
          <div class="ui icon header">
            <img class="ui image small link" src="../packages/images/friendship.png"></img>
            Friendship
          </div>
          <p>Members of Theta Upsilon know this phrase: "Come for the service, stay for the friendship." Learn more about making friendships that last a lifetime through APO.</p>
          <p><a class="ui teal right labeled icon button" href="#">Find Friends<i class="right chevron icon"></i></a></p>
        </div>
        <div class="column">
          <div class="ui icon header">
            <img class="ui image small link" src="../packages/images/service-image.png"></img>
            Service
          </div>
          <p>Theta Upsilon is commited to helping their chapter, campus, community and nation through volunteering.</p>
          <p><a class="ui teal right labeled icon button" href="#">Serve <i class="right chevron icon"></i></a></p>
        </div>
      </div>
    </div>
  </div>
@stop
