@extends('master_clean')

@section('content')
    <div class="container">
        <div class="panel">
            <ul class="list-group">
                @foreach($officers as $officer)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-4">
                                @if($officer->currentUser != null)
                                    {!!Html::image($officer->currentUser->pictureURL(150),'img-thumbnail img-responsive')!!}
                                @else
                                    {!!Html::image('http://gravatar.com/avatar/?s=150&d=mm')!!}
                                @endif
                            </div>
                            <div class="col-sm-8">
                                @if($officer->currentUser != null)
                                    <h1>{{$officer->Display}}</h1>
                                    <p>Email: {!!Html::mailTo($officer->Office.'@apo.case.edu')!!}</p>
                                    <h3>{{$officer->currentUser->getFullDisplayName()}}</h3>
                                    <h4>Other Contact Information:</h4>

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