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
    {!!Html::style('css/bootstrap-theme.min.css')!!}
    {!!Html::style('css/mobile-master.css')!!}
    {!!Html::style('css/master.css')!!}
    @yield('stylesheets')
</head>

<body id="home">

<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <!-- Title -->
        <div class="navbar-header pull-left">
            <a href="/" class="navbar-brand">APO @ CWRU</a>
        </div>

        <!-- 'Sticky' (non-collapsing) right-side menu item(s) -->
        <div class="navbar-header pull-right">
            <ul class="nav pull-left">
                @if($currentUser != null)
                    <!-- This works well for static text, like a username -->
                    <li class="navbar-text pull-left">Signed in as: {{$currentUser->first_name}} {{$currentUser->last_name}}</li>
                    <!-- Add any additional bootstrap header items.  This is a drop-down from an icon -->
                    <li class="dropdown pull-right">
                        <a href="#" data-toggle="dropdown" style="color:#777; margin-top: 5px;"
                           class="dropdown-toggle"><span
                                    class="glyphicon glyphicon-user"></span><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/users/{{$currentUser->cwru_id}}"
                                   title="Profile">Profile</a>
                            </li>
                            <li>
                                <a href="/logout" title="Logout">Logout </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown pull-right">
                        <a href="/login?redirect_url={{ Request::url() }}" style="color:#777; margin-top: 5px;" class="dropdown-toggle"><span
                                    class="glyphicon glyphicon-user"></span><b> Login</b></a>
                    </li>
                @endif
            </ul>

            <!-- Required bootstrap placeholder for the collapsed menu -->
            <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle"><span
                        class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>

        @if(array_key_exists('left_menu_items',View::getSections()))
            <!-- The Collapsing items            navbar-left or navbar-right -->
            <div class="collapse navbar-collapse navbar-left">
                <!--                      pull-right keeps the drop-down in line -->
                <ul class="nav navbar-nav pull-left">
                    @yield('left_menu_items')
                </ul>
            </div>
        @endif
        @if(array_key_exists('right_menu_items',View::getSections()))
            <!-- Additional navbar items -->
            <div class="collapse navbar-collapse navbar-right">
                <!--                      pull-right keeps the drop-down in line -->
                <ul class="nav navbar-nav pull-right">
                    @yield('right_menu_items')
                </ul>
            </div>
        @endif
    </div>
</nav>
@yield('content')
@yield('scripts')
</body>

</html>
