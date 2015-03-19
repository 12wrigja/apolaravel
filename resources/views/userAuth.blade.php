
<div class="ui dropdown item" >
	{{LoginController::currentUser()->firstName}} {{LoginController::currentUser()->lastName}}
	<i class="dropdown icon"></i>
	<div class="menu">
		<a class="item" href="/users/{{LoginController::currentUser()->cwruID}}">Profile</a>
		<a class="item">Contract Status</a>
		<a class="item">File a Service Report</a>
		<a class="item" href="/logout?redirect_url={{{Request::url()}}}">Logout</a>
	</div>
</div>
@if(null != Hours::currentHours(LoginController::currentUser()->cwruID))
<a class="item">
{{round(Hours::currentHours(LoginController::currentUser()->cwruID),1)}}
<i class="time icon"></i>
</a>
@endif
<a class="item">
{{Meetings::currentMeetings(LoginController::currentUser()->cwruID)}}
<i class="calendar icon"></i>
</a>