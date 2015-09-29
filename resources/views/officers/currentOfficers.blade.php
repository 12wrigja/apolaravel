@extends('master_scrub')

@section('content')
    <div class="container">
        <div class="panel">
            <ul class="list-group">
                @foreach($offices as $office)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-4">
                                @if($office->currentOfficer() != null)
                                    {!!Html::image($office->currentOfficer()->pictureURL(150),'img-thumbnail img-responsive')!!}
                                @else
                                    {!!Html::image('http://gravatar.com/avatar/?s=150&d=mm')!!}
                                @endif
                            </div>
                            <div class="col-sm-8">
                                @if($office->currentOfficer() != null)
                                    <h1>{{$office->display_name}}</h1>
                                    <p>Email: {!!Html::mailTo($office->email.'@apo.case.edu')!!}</p>
                                    <h4><a href="{{route('user_show',['id'=>$office->currentOfficer()->id])}}">{{$office->currentOfficer()->getFullDisplayName()}}</a></h4>
                                    <p></p>
                                @else

                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection