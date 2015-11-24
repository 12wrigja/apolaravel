<p>Hi Membership VP,</p>

<p>{{$userFullName}} (CWRU ID: {{$userId}}) signed an {{$contractName}} for the {{$semesterText}} APO semester.</p>

@if($committees != null)

    <p>Here are their responses from the committee survey. The committees are listed in order of preference.<p/>

    <ol>
        @foreach($committees as $committee)
            <li>{{$committee}}</li>
        @endforeach
    </ol>

@endif

@if($reason != null)
    <p>Below is the reason they gave for signing an inactive contract:</p>
    <p>{{$reason}}</p>
@endif

@if($contractName == 'Associate Contract')
    <p>They have also been instructed to sign the associate contract google form, located <a
                href="https://docs.google.com/forms/d/1KSIwk6IHRVXf6RIHAVYSdnAQ27cCRY7RCdnO6MCUUFQ/viewform"
                target="_blank">here</a></p>
@endif

<p>In LFS,</p>

<p>The APO Theta Upsilon Website</p>