@extends('master_scrub')

@section('nav_menu_items')
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Theta Upsilon
            Chapter <span
                    class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a class="item">Chapter History</a></li>
            <li><a class="item" href="{{route('officers')}}">Chapter Officers</a></li>
            <li><a class="item" href="{{route('users')}}">Chapter Members</a></li>
            <li><a class="item">Alumni Information</a></li>
            <li><a class="item">Theta Upsilon Traditions</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Joining APO<span
                    class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a class="item">Rush and Pledging</a></li>
            <li><a class="item">APO's Principles</a></li>
            <li><a class="item">Hazing Policy</a></li>
            <li><a class="item">Rush FAQ</a></li>
        </ul>
    </li>
@stop