<!DOCTYPE html>
<html lang="en">
<head>
<meta name="google-site-verification" content="9r2l5dvlDlYAziJiMFjYdptQXaB1O5V4-m7RtLzR_Pk" />
<meta name="google-site-verification" content="iNtgLefQhRIGdDa_1f_T1eyV3NAT7C5ENBGC90O08mg" />
    <!-- Standard Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" user-scalable="no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user_api" content="{{route('user_show',['id'=>':id'])}}">
    <meta name="service_report_api" content="{{route('report_show',['type'=>'service_reports','id'=>':id'])}}">
    <meta name="brotherhood_report_api" content="{{route('report_show',['type'=>'brotherhood_reports','id'=>':id'])}}">
    <meta name="chapter_meeting_api" content="{{route('report_show',['type'=>'chapter_meetings','id'=>':id'])}}">
    <meta name="exec_meeting_api" content="{{route('report_show',['type'=>'exec_meetings','id'=>':id'])}}">
    <meta name="pledge_meeting_api" content="{{route('report_show',['type'=>'pledge_meetings','id'=>':id'])}}">
    @yield('metadata')

            <!-- Site Properities -->
    <title>Alpha Phi Omega at Case Western Reserve University</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">

    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    {!!Html::style('css/summernote.css')!!}
    {!!Html::style('css/bootstrap_flatly.min.css')!!}
    {!! Html::style('css/master.css') !!}
    {!! Html::style('css/mobile-master.css') !!}
    {!! Html::style('css/dropzone.css') !!}
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
            <a href="{{route('home')}}" class="navbar-brand">APO @ CWRU</a>
        </div>

        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                @yield('nav_menu_items')
                @if(isset($currentUser))
                    @include('userAuth')
                @else
                    <li class="dropdown pull-right">

                        <a href="{!! route('login',['redirect_url'=>Request::url()]) !!}"
                           class="dropdown-toggle">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')
{!!Html::script(elixir('js/bundle.js'))!!}
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
@yield('scripts')
</body>

</html>
