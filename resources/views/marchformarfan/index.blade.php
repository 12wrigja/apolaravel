@extends('master_full')

@section('content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="css/images/m4mlogov2.png" alt="">
                    <div class="intro-text">
                        <span class="name"></span>
                        <hr class="star-light">
                        <span class="skills">An annual 5k race/ 3k walk to raise money and awareness for The Marfan Foundation</span>
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
                    <p>Learn more about Marfan Syndrome from The Marfan Foundation <a
                                href="http://www.marfan.com/">here</a>, or click on their logo below!</p>
                    <a href="http://www.marfan.com/" target="_blank"><img class="img-responsive text-center hidden-lg"
                                                                          src="css/images/Marfan Foundation_logo_tag_hires_CMYK.jpg"
                                                                          alt="The March for Marfan"></a>
                </div>
                <div class="col-lg-4">
                    <h3>About March for Marfan</h3>
                    <p>March for Marfan was started 11 years ago by Maya Brown-Zimmerman as a brother of Case Western’s
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
            <div class="col-lg-8 col-lg-offset-2">
                <a href="http://www.marfan.com/" target="_blank"><img
                            class="img-responsive text-center hidden-md hidden-sm hidden-xs"
                            src="css/images/Marfan Foundation_logo_tag_hires_CMYK.jpg"
                            alt="The March for Marfan"></a>
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
                    <p>The race is held on <strong>March 26th, 2017</strong>. Check-in is at <strong>9 AM</strong>, the
                        race begins at <strong>10 AM</strong> and the walk begins at <strong>10:15 AM</strong>. The
                        event lasts until approximately <strong>12:30 PM</strong>. A light breakfast and lunch will be
                        provided.</p>
                    <h3>Where</h3>
                    <p>The event check-in and activities will take place in Wade Commons (marked on the map). Parking
                        can
                        be found in the Lot 46 parking garage, behind the football field off of E 118th St. At the toll
                        booth for Lot 46, mention you are attending March for Marfan and your parking fee will be
                        covered. For any concerns, please email Joseph Thiel
                        at {!!Html::mailTo('marchformarfan@apo.case.edu')!!}</p>
                </div>
                <div class="col-lg-4">
                    <h3>Map</h3>
                    <p>The starting point for the race is Wade Commons, located at <a
                                href="https://www.google.com/maps/place/Wade+Commons,+11451+Juniper+Rd,+Cleveland,+OH+44106/@41.5130505,-81.607398,17z/data=!3m1!4b1!4m2!3m1!1s0x8830fb8ac678cabb:0xb1d1e338d803f678"
                                target="_blank">11451 Juniper Rd, Cleveland, OH 44106</a>, which is also shown on the map below.</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2384.9886369007863!2d-81.60703659325259!3d41.51315501384533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8830fb8ac678cabb%3A0xb1d1e338d803f678!2sWade+Commons%2C+11451+Juniper+Rd%2C+Cleveland%2C+OH+44106!5e0!3m2!1sen!2sus!4v1458011639785" width="640"
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
                    <h2>2017 Sponsors</h2>
                    <hr class="star-primary">
                </div>
            </div>
            {{--<div class="row">--}}
            {{--<div class="col-sm-4">--}}
            {{--<img src="css/images/logos/tommys.png" class="img-responsive  img-centered" alt="">--}}
            {{--</div>--}}
            {{--<div class="col-sm-4">--}}
            {{--<img src="css/images/logos/liquidplanet.png" class="img-responsive img-centered" alt="">--}}
            {{--</div>--}}
            {{--<div class="col-sm-4">--}}
            {{--<img src="css/images/logos/barnesandnoble.png" class="img-responsive  img-centered" alt="">--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
            {{--<div class="col-sm-4">--}}
            {{--<img src="css/images/logos/brueggers.png" class="img-responsive  img-centered" alt="">--}}
            {{--</div>--}}
            {{--<div class="col-sm-4">--}}
            {{--<img src="css/images/logos/buffalowildwings.png" class="img-responsive  img-centered" alt="">--}}
            {{--</div>--}}
            {{--<div class="col-sm-4">--}}
            {{--<img src="css/images/logos/fairmount.png" class="img-responsive  img-centered" alt="">--}}
            {{--</div>--}}
        </div>
        </div>
    </section>

    <section class="success" id="register">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Registration</h2>
                    <hr class="star-light">
                    <div>
                        <a href="{!!URL::to('images/uploads/Cleveland17_flyer-3.pdf')!!}">
                    {!! HTML::image('images/uploads/Cleveland17_flyer-3.png')!!}
                        </a>
                    </div>
                    <h3>
                    {!! HTML::link('https://give.marfan.org/cleveland/events/2017-cleveland-walk-for-victory/e88347','Register
                    here!') !!}
                    </h3>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('stylesheets')
    {!! Html::style('css/freelancer.css') !!}
@endsection
