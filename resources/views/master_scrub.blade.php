<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" user-scalable="no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('metadata')

            <!-- Site Properities -->
    <title>Alpha Phi Omega at Case Western Reserve University</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
    {!!Html::style('css/bootstrap-theme.min.css')!!}
    {!! Html::style('css/master.css') !!}
    {!! Html::style('css/mobile-master.css') !!}
    @yield('stylesheets')
</head>

<body id="home">
<nav role="navigation" class="navbar-fixed-top navbar-default">
    <div class="container">

        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">APO @ CWRU</a>
        </div>

        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                @yield('nav_menu_items')
                @if($currentUser != null)
                    @include('userAuth')
                @else
                    <li class="dropdown pull-right">

                        <a href="{!! route('login',['redirect_url'=>Request::url()]) !!}" style="color:#777; margin-top: 5px;"
                           class="dropdown-toggle"><span
                                    class="glyphicon glyphicon-user"></span><b> Login</b></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')
{!!Html::script('js/bundle.js')!!}
@yield('scripts')
</body>

</html>
