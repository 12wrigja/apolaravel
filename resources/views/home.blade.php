@extends('master_full')

@section('stylesheets')
    {!!Html::style('css/homepage.css')!!}
@stop

@section('scripts')
    {!!Html::script('js/homepage.js')!!}
@stop

@section('content')
    <div class="masthead">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($carouselItems as $index => $cItem)
                    <li data-target="#myCarousel" data-slide-to="{{$index}}" @if($index==0) class="active" @endif></li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach($carouselItems as $index => $cItem)
                    <div class="item
                        @if($index==0)
                            active
                            @endif
                            ">
                        <div class="background"
                             style="background:url({!! $cItem->background_image !!}) center center; background-size: cover">

                        </div>
                        @if($cItem->title != null)
                            <div class="container">
                                <div class="carousel-caption">
                                    <h1>{{$cItem->title}}</h1>
                                    @if($cItem->caption != null)
                                        <p>{{$cItem->caption}}</p>
                                    @endif
                                    @if($cItem->action_text != null && $cItem->action_url != null)
                                        <p><a class="btn btn-lg btn-primary" href="{!! $cItem->action_url !!}"
                                              role="button" target="_blank">{{$cItem->action_text}}</a></p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="text-center">
        <h1>What is APO all about?</h1>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="row text-center">
                <div class="col-sm-4">
                    <div class="homepage-icon-container">
                        {!!Html::image('css/images/leadership-image.png','APO Leadership
                        Icon',array('class'=>'img-responsive homepage-icon'))!!}
                    </div>
                    <h3>Leadership</h3>

                    <p>Through LEADS courses and various executive positions, APO provides many opportunities to enhance
                        your leadership skills.</p>
                </div>
                <div class="col-sm-4">
                    <div class="homepage-icon-container">
                        {!!Html::image('css/images/friendship-image.png','APO Friendship Icon',
                        array('class'=>'img-responsive homepage-icon'))!!}
                    </div>
                    <h3>Friendship</h3>

                    <p>Members of Theta Upsilon know this phrase: "Come for the service, stay for the friendship." Learn
                        more about making friendships that last a lifetime through APO.</p>
                </div>
                <div class="col-sm-4">
                    <div class="homepage-icon-container">
                        {!!Html::image('css/images/service-image.png','APO Service Icon', array('class'=>'img-responsive
                        homepage-icon'))!!}
                    </div>
                    <h3>Service</h3>

                    <p>Theta Upsilon is committed to helping their chapter, campus, community and nation through
                        volunteering.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
@stop
