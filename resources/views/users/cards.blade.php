<div class="ui five doubling cards">
@foreach($users as $user)
@include('users.userCard')
@endforeach
</div>
{{$users->links()}}