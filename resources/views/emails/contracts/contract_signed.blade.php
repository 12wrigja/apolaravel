<p>Hi {{$userFullName}},</p>

<p>Congratulations on signing an <strong>{{$contractName}}</strong> for the {{$semesterText}} APO semester! </p>

@if($committees != null)

    <p>Here are your responses from the committee survey. The committees are listed in order of preference.<p/>

    <ol>
        @foreach($committees as $committee)
            <li>{{$committee}}</li>
        @endforeach
    </ol>

@endif

@if($reason != null)
    <p>Below is the reason you gave for signing an inactive contract:</p>
    <p>{{$reason}}</p>
@endif

@if($contractName == 'Associate Contract')
    <p>If you have not done so already, please fill out the google form for associate contracts, located <a
                href="https://docs.google.com/forms/d/1KSIwk6IHRVXf6RIHAVYSdnAQ27cCRY7RCdnO6MCUUFQ/viewform"
                target="_blank">here</a></p>
@endif

<p>An email containing this information has been sent to the Membership VP.</p>

<p>In LFS,</p>

<p>The APO Theta Upsilon Website</p>