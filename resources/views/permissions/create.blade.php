@extends('static_fullscreen')

@section('scripts')
@parent

@stop

@section('masthead')
@if($errors->all() != null)
<div id="errorMessage" class="ui message">
	<div class="header">
		Errors:
	</div>
	 {{HTML::ul($errors->all(), array('class'=>'list'))}} 
</div>
@endif

<script type="text/javascript">
$(document).ready(function(){
	$('.ui.search')
	  .search({
	    type   : 'standard',
	    apiSettings: {
			url: '/users/search?query={query}&attr=firstName,lastName,cwruID,status&result_format=title:firstName%20lastName;description:cwruID'
	    },
	    debug: true,
	    verbose: true,
	    onSelect: function(event){
		    console.log(event);
		    var text = event.currentTarget.children[0].innerText;
		    var parts = text.split("\n");
		    var fullName = parts[0];
		    var cwruID = parts[1];
			$('#cwruIDField').val(fullName);
	    }
	  });
});
</script>
{{Form::model(null,array('url' => array('permissions'), 'class'=>'ui form'))}}
		<div class="ui search">
        <div class="ui icon input">
            <input class="prompt" type="text" placeholder="Search APO users..." autocomplete="off"> <i class="search icon"></i>
        </div>
        <div class="results"></div>
    </div>
    	{{Form::hidden('case_id',null,array('id'=>'cwruIDField'))}}
        {{ Form::label('group', 'Group') }}
        {{ Form::dropdown('group_id',$groups)}}
        {{ Form::submit('Assign Permission Group', array('class'=>'ui submit button')) }}

{{Form::close()}}

@stop