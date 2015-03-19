@extends('static_fullscreen')

@section('masthead')
<script>

function getUsers(page) {
    $.ajax({
        url : '?page=' + page,
        dataType: 'json',
    }).done(function (data) {
        $('.usertable').html(data);
    }).fail(function () {
        alert('Users could not be loaded.');
    });
}

function search(text){
	$.ajax({
        url : '?query=' + text,
        dataType: 'json',
    }).done(function (data) {
        $('.usertable').html(data);
    }).fail(function () {
        alert('Search could not be completed.');
    });
}

$(document).ready(function() {
    $(document).on('click', '.pagination a', function (e) {
    	e.preventDefault();
    	var num = $(this).attr('href').split('page=')[1];
    	location.hash = num;
        getUsers(num);
    });
    $("#searchForm").submit(function(e){
		e.preventDefault();
		var text = $('#searchForm input[name="query"]').val();
		search(text);
    });
});
</script>

<style>
.ui.pagination.menu{
	margin: 10 0;
}
#searchForm{
	width:100%;
	text-align:right;
}
#searchForm input{
	width:25%;
	display:inline;
}
#searchForm .ui.button{
	width:10%;
}
</style>

@if(Session::has('message'))
	<div class="ui message">
		{{Session::get('message')}}
	</div>
@endif
<a class="ui button" href="{{URL::to('users/create')}}">Create a user</a>
{{Form::open(array('url'=>'#','class'=>'ui action input','id'=>'searchForm','method'=>'GET'))}}
{{Form::text('query')}}
{{Form::button('Search',array('class'=>'ui button')) }}
{{Form::close()}}

<div class="usertable">
@include('users.table')
</div>
@stop