@extends('master_full')

@section('content')
    <div class="container">
        <div class="panel">
            <ul class="list-group">
                @foreach($offices as $office)
                    @if($office->currentOfficers()->count() == 0)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4">
                                    {!!Html::image('http://gravatar.com/avatar/?s=150&d=mm')!!}
                                </div>
                                <div class="col-sm-8">
                                    <h1>{{$office->display_name}}</h1>

                                    <p>Email: {!!Html::mailTo($office->email.'@apo.case.edu')!!}</p>
                                </div>
                            </div>
                        </li>
                    @else
                        @foreach($office->currentOfficers() as $officer)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {!!Html::image($officer->pictureURL(150),'img-thumbnail img-responsive')!!}
                                    </div>
                                    <div class="col-sm-8">
                                        <h1>{{$office->display_name}}</h1>

                                        <p>Email: {!!Html::mailTo($office->email.'@apo.case.edu')!!}</p>
                                        <h4>
                                            <a href="{{route('user_show',['id'=>$officer->id])}}">{{$officer->getFullDisplayName()}}</a>
                                        </h4>

                                        <p></p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endsection