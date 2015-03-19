@extends('static_fullscreen')

@section('stylesheets')
@parent
<link rel="stylesheet" type="text/css" href="../packages/css/card.min.css">
<style>
#userCards .card .description{
	height:90px;
	text-overflow: ellipsis;
	overflow:hidden;
}
.masthead.segment .image{
margin:0;
}
</style>
@stop

@section('scripts')
@parent
<script>

function getUsers(page) {
	startLoader();
    $.ajax({
        url : '?page=' + page,
        dataType: 'json',
    }).done(function (data) {
        $('#userCards').html(data);
        endLoader();
    }).fail(function () {
    	endLoader();
        alert('Users could not be loaded.');
    });
}

function search(text){
	startLoader();
	$.ajax({
        url : '?query=' + text,
        dataType: 'json',
    }).done(function (data) {
        $('#userCards').html(data);
        endLoader();
    }).fail(function () {
    	endLoader();
        alert('Search could not be completed.');
    });
}

function startLoader(){
	$("#cardLoad").addClass("active");
}
function endLoader(){
	$("#cardLoad").removeClass("active");
}
$(document).ready(function() {
    $(document).on('click', '.pagination a', function (e) {
    	e.preventDefault();
    	var num = $(this).attr('href').split('page=')[1];
    	location.hash = num;
        getUsers(num);
    });
    $("#searchForm button").click(function(e){
    	e.preventDefault();
		var text = $('#searchForm input[name="query"]').val();
		search(text);
    });
    $("#searchForm").submit(function(e){
		e.preventDefault();
		var text = $('#searchForm input[name="query"]').val();
		search(text);
    });
});
</script>
@stop

@section('masthead')
<h2>APO Members</h2>
<style>
.ui.pagination.menu{
	margin: 10 0;
}
#searchForm{
	display:block;
	text-align:right;
}
#searchForm input{
	width:25%;
	display:inline;
}
.ui.cards > .card > .content > a.header{
	height: 3em;
}
.ui.cards > .card .meta, .ui.card .meta{
	height: 2.5em;
}
#loadContainer{
	background: none;
	padding: none;
	box-shadow: none;
}

@media only screen and (max-width : 768px) {
	#searchForm input{
		width:auto;
	}
}
</style>
{{Form::open(array('url'=>'#','class'=>'ui action input','id'=>'searchForm','method'=>'GET'))}}
<!-- {{Form::button('Filter Search',array('class'=>'ui button'))}} -->
{{Form::text('query')}}
{{Form::button('Search',array('class'=>'ui button')) }}
{{Form::close()}}
<div id="loadContainer" class="ui segment">
<div id="cardLoad" class="ui dimmer">
	<div class="ui large loader">
	</div>
</div>
<div id="userCards">
@include('users.cards')
</div>
</div>
@stop