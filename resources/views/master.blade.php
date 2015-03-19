<html>
<head>
<!-- Standard Meta -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

<!-- Site Properities -->
<title>Alpha Phi Omega at Case Western Reserve University</title>

<link
	href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700'
	rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css"
	href="/dist/semantic.css">
<link rel="stylesheet" type="text/css" href="/packages/css/homepage.css">
@yield('stylesheets')

<script
	src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
<script src="/dist/semantic.js"></script>
<script src="/packages/javascript/homepage.js"></script>
@yield('scripts')
</head>

<body id="home">
	<div class="ui inverted page grid masthead segment">
		<div class="column">
			<div class="inverted primary tiered pointing ui menu">
			<div class="menu">
				<div class="left menu">@yield('left_menu_items')</div>
				<div class="right menu">
					@yield('right_menu_items')
					<div class="item vertical divider"></div>
					@if(null == LoginController::currentUser()) 
					@if(0 == Config::get('app.debug'))
						<a class="item" href="/login">Login via Case SSO</a>
					@else
						{{Form::open()}}
					<form action="/login_debug" method="POST">
						Username: <input type="text" name="debug_username"> <input
							type="hidden" name="redirect_url" value="{{{Request::url()}}}" /> <input
							type="submit" value="Login">
					</form>
					@endif 
					@else 
					@include('userAuth') 
					@endif
					</div>
				</div>
				<div class="ui submenu">
					
				</div>
			</div>
			@yield('masthead')
		</div>
	</div>
	@yield('content') @yield('footer')

</body>

</html>
