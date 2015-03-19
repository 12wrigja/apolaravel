@extends('static_fullscreen')

@section('masthead')
<a class="ui button" href="/permissions/create">Assign Permissions</a>

<table class="ui inverted table">
<thead>
<th>Case ID</th>
<th>Name</th>
<th>Group</th>
<th></th>
</thead>
<tbody>
@foreach($groupData as $grouping)
<tr>
	<td>{{$grouping->case_id}}</td>
	<td>{{$grouping->firstName ." ". $grouping->lastName}}</td>
	<td>{{$grouping->name}}</td>
	<td>
</tr>
@endforeach
</tbody>
</table>
@stop