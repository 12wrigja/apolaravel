@extends('master_scrub')

@section('nav_menu_items')
    <li><a class="item" href="/">About APO</a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Theta Upsilon
            Chapter <span
                    class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a class="item">Chapter History</a></li>
            <li><a class="item" href="/officers">Chapter Officers</a></li>
            <li><a class="item">Alumni Information</a></li>
            <li><a class="item">Theta Upsilon Traditions</a></li>
        </ul>
    </li>
    <li><a class="item" href="">Joining APO</a></li>
@stop