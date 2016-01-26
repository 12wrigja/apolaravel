@extends('master_full')

@section('content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="css/images/m4mlogo.png" alt="">
                    <div class="intro-text">
                        <span class="name">March for Marfan</span>
                        <hr class="star-light">
                        <span class="skills">An annual 5k race/ 3k walk to raise money and awareness for the Marfan Foundation</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <h3>About Marfan Syndrome</h3>
                    <p>Marfan syndrome is a life-threatening genetic disorder affecting many people here in Cleveland.
                        It causes the body's connective tissue, which is found throughout the body, to not function
                        properly. This affects many body systems, including the skeleton, heart, lungs, and eyes. What
                        makes Marfan life-threatening is that the aorta can grow to be so large that the walls weaken
                        and tear, which causes internal bleeding and can cause death if not immediately treated. This is
                        the most serious of the many complications Marfan syndrome causes. About 1 in every 5,000 people
                        are affected by Marfan syndrome.</p>
                </div>
                <div class="col-lg-4">
                    <h3>About March for Marfan</h3>
                    <p>March for Marfan was started 10 years ago by Maya Brown-Zimmerman as a brother of Case Western’s
                        Alpha Phi Omega-Theta Upsilon chapter. Maya has Marfan Syndrome, and began the march with the
                        help and support of The Marfan Foundation and her chapter. Over the years, several other
                        brothers in Case Western’s chapter have had similar connective tissue disorders, or have had
                        family members with Marfan Syndrome. For this reason, the March for Marfan event holds a
                        personal meaning for the chapter at CWRU. Today, Theta Upsilon continues holding the event to
                        support these brothers, as well as other members of the community affected by Marfan Syndrome,
                        and Maya continues to advise and mentor for the march.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="success" id="involve">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Get Involved</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <h3>When</h3>
                    <p>The race is held on <strong>March 21st, 2015</strong>. Check-in is at <strong>9 AM</strong>, the
                        race begins at <strong>10 AM</strong> and the walk begins at <strong>10:15 AM</strong>. The
                        event lasts until approximately 12:30 PM. A light breakfast and lunch will be provided.</p>
                    <h3>Where</h3>
                    <p>The event check-in and activities will take place in Wade Common(marked on the map). Parking can
                        be found in the Lot 46 parking garage, behind the football field off of E 118th St. At the toll
                        booth for Lot 46, mention you are attending March for Marfan and your parking fee will be
                        covered. For any concerns, please email: marchformarfan@apo.case.edu</p>
                </div>
                <div class="col-lg-4">
                    <h3>Map</h3>
                    <iframe src="https://www.google.com/maps/d/embed?mid=zcSOOiVtNxQ0.k8caDix0RaCA" width="640"
                            height="480"></iframe>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <a href="#register" class="btn btn-lg btn-outline">
                        Register Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="sponsors">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Sponsors</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <img src="css/images/logos/tommys.png" class="img-responsive  img-centered" alt="">
                </div>
                <div class="col-sm-4">
                    <img src="css/images/logos/liquidplanet.png" class="img-responsive img-centered" alt="">
                </div>
                <div class="col-sm-4">
                    <img src="css/images/logos/barnesandnoble.png" class="img-responsive  img-centered" alt="">
                </div>
                </div>
            <div class="row">
                <div class="col-sm-4">
                    <img src="css/images/logos/brueggers.png" class="img-responsive  img-centered" alt="">
                </div>
                <div class="col-sm-4">
                    <img src="css/images/logos/buffalowildwings.png" class="img-responsive  img-centered" alt="">
                </div>
                <div class="col-sm-4">
                    <img src="css/images/logos/fairmount.png" class="img-responsive  img-centered" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="success" id="register">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Registration</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <h3>Online</h3>
                    <p>Online registration can be completed by filling out <a href="https://docs.google.com/spreadsheet/embeddedform?formkey=dGZKTS14RzZCYTU0QXpyTm9zeFpQZVE6MA" target="_blank">this form</a>.</p>
                </div>
                <div class="col-lg-4">
                    <h3>Mail In</h3>
                    <p>The Mail-in Registration Form can be downloaded by clicking here. Important Information:
                        <ul>
                        <li>Check-in starts at 9:00 AM and goes until 9:50 AM</li>
                        <li>The event will be held on the campus of Case Western Reserve University on March 21st, 2015</li>
                        <li>Registration runs until March 13th and is $20 a person (each participant will receive a t-shirt)</li>
                        <li>Groups of 4 can register for $60 total</li>
                        <li>Late Registration begins March 14th (late registration participants will not be guaranteed a t-shirt)</li>
                        <li>Checks can be made out to Alpha Phi Omega and should be mailed to:<br><br>
                            Sophia Senderak<br>
                            1626 E 115th St. #219<br>
                            Cleveland, OH 44106-3937</li>
                    </ul></p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('stylesheets')
    {!! Html::style('css/freelancer.css') !!}
@endsection