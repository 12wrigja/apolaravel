@extends('templates.crud_template')


@section('crud_form')

    <h1>FAQ</h1>

    <p>Welcome to the new APO Website! This is probably all very new to everyone, and so below is a quick FAQ full of
        questions people might have and some answers.</p>

    <h3>How do I use things?</h3>
    <p>Good question! One of the existing issues with the old website was the organizational structure. This has been
        simplified: almost anything you could want to do you can now do from the dropdown menu at the top right section
        of the screen. Simply log in using Case's SSO system (same as for Blackboard) and you will be returned
        automatically back to this site. Once you are logged in, you can click on your name from the dropdown and a list
        will appear with all the information you might find useful, such as submitting service and brotherhood reports,
        checking your contract status and signing out. If you are an exec board member, any additional functionality you
        have as an exec board member will be listed there as well.</p>
    <p>If you can't find what you are looking for there, try having a look at the various menu bar options just to the
        left od your name. You can find information about the chapter under the Theta Upsilon Chapter tab, including
        current officer contact information, a complete member search system, and information about the chapter in
        general (currently under construction. If you know what should go here, keep reading down to the section on
        collaboration).</p>

    <h3>Where is all my data?</h3>

    <p>Don't worry! The old APO database is completely intact. It's just taking a while to move over all the data. Right
        now, the following pieces of data are successfully migrated over:</p>
    <ul>
        <li>Service reports</li>
        <li>Users (all user data, not just names and CWRU ID's.)</li>
        <li>Chapter Meeting attendance</li>
        <li>Pledge Meeting attendance</li>
        <li>Exec Meeting Attendance (where recorded. This has historically only been recorded in unusual cases).</li>
        <li>Dues Data (paid vs not paid)</li>
        <li>Currently signed contracts (although the old data for this is incorrect. This willl be manually fixed soon).
            <ul>
                @if($currentUser != null)
                    <li>You can check your current signed contract <a
                                href="{{route('user_status',['id'=>$currentUser->id])}}">here</a>, or choose the
                        Contract Status option from the dropdown in the top right. If your contract status is not
                        correct, please email both the webmaster AND the membership VP
                        at {!! Html::mailto('webmaster@apo.case.edu') !!}
                        and {!! Html::mailto('membership@apo.case.edu') !!}.
                    </li>
                @else
                    <li>You currently are <b>not</b> logged in. Log in using the button in the top right, and check this
                        page
                        again for instructions to check your current contract status.
                    </li>
                @endif
            </ul>
        </li>
    </ul>

    <h3>Why did things change?</h3>
    <h6>In Summary: </h6> <p> Things were breaking and the existing codebase was unmaintainable.</p>
    <h6>Long Answer: </h6>
    <p>For those of you that don't know, the previous version of the APO Website is ancient. The first version launched
        in 2003, and the code that it uses is very reminiscent of the time. No class structures, basic templating, and
        lots of confusing and poorly documented code. The old code base used RAW SQL queries, leading to vulnerability
        injection issues, as well as relying on insecure storage of sensitive data. There were also many issues caused
        by lack of documentation and poor coding practices. I (the webmaster as of 2015) decided this needed to change
        in order to preserve the sanity of myself and future webmasters, as well as bring Theta Upsilon's website into
        the current generation.</p>
    <p>Hopefully changing the core of the website will lead to a more extensible platform for future webmasters to work
        with, as well as provide increased reliability and reduced random issues. If you know PHP (<b>especially</b> the
        Laravel framework), Javascript, or SASS,
        I would love your help. The source code to the project is available on Github <a
                href="https://github.com/12wrigja/apolaravel">here</a> and anyone is welcome to make Pull Requests with
        features and bug fixes. I also would like help thememing the website and filling in various static sections. For
        those, you can email the current webmaster at {!! Html::mailto('webmaster@apo.case.edu') !!} to see what needs
        doing or make suggestions of your own.</p>




@endsection