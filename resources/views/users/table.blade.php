<table class="ui inverted blue table">
<thead>
<th>First Name</th>
<th>Last Name</th>
<th>CWRU ID</th>
<th>Status</th>
<th></th>
<th></th>
</thead>
<tbody>
@foreach($users as $key=>$value)
<tr>
	<td>{{$value -> firstName}}</td>
	<td>{{$value -> lastName}}</td>
	<td>{{$value -> cwruID}}</td>
	<td>{{$value -> status() -> first() -> status }}</td>
	
	<td><a class="ui button" href="{{URL::to('/users/' .$value -> cwruID )}}">View Profile</a></td>
	<td>{{ Form::open(array('url' => '/users/'.$value->cwruID)) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete User', array('class' => 'ui button red')) }}
                {{ Form::close() }}</td>
</tr>
@endforeach

</tbody>
</table>
{{$users->links()}}