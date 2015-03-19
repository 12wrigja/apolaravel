@extends('static_fullscreen')

@section('scripts')
    @parent
    <script>
            var caseIDs = [];
            $(document).ready(function(){
                $('#userForm').submit(function(e){
                    e.preventDefault();
                });
                $('.ui.search')
                        .search({
                            type   : 'standard',
                            apiSettings: {
                                url: '/users/search?query={query}&attr=firstName,lastName,cwruID,status&result_format=title:firstName%20lastName;description:cwruID'
                            },
                            debug: true,
                            verbose: true,
                            onSelect: function(result,response){
                                console.log('Result: '+JSON.stringify(result,null,4));
                                var caseID = result.description;
                                addUser(caseID);
                                console.log(caseIDs);
                                return true;
                            }
                        });
            });
        function addUser(user){
            if($.inArray(user,caseIDs) == -1){
                caseIDs.push(user);
                var div = document.createElement("div");
                div.innerHTML = user;
                $('#brothers').append(div);
                console.log(caseIDs);
            }
        }
        function submitForm(){
            var json = {"submitter" : "jow5"};
            json.caseIDs = caseIDs;
            json = JSON.stringify(json);
            console.log(json);
            $.post(
                    "/api/testpost",
                    json,
                    function(data){
                        console.log("Response:\n"+data);
                    }
            )
        }
    </script>
@stop

@section('masthead')
    <div id="brothers">

    </div>
<form class = "ui form" id="userForm">
    <div class="ui search">
        <div class="ui icon input">
            <input class="prompt" type="text" placeholder="Search APO users..." autocomplete="off"> <i class="search icon"></i>
        </div>
        <div class="results"></div>
    </div>
    <input class="ui button" id="addButton" type="button" value="Add Brother">
    <input class="ui button" type="button" value="Submit Service Event" onclick="submitForm();">
</form>

@stop