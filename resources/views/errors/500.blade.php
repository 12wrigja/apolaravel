@extends('templates.crud_template')

@section('crud_form')
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-4">
                    {!!Html::image('css/images/torch-logo-new.png','APO Torch Logo',array('class'=>'img-responsive'))!!}
                </div>
                <div class="col-sm-8">
                    <h1 class="ui inverted header">Uh Oh!</h1>
                    <p class="inverted">
                        @if(isset($exception))
                            {{$exception->getMessage()}}
                        @else
                            We're sorry - an unknown error occurred.
                        @endif
                            If this keeps occurring, email the webmaster at
                            {!!Html::mailTo('webmaster@apo.case.edu')!!}.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection
