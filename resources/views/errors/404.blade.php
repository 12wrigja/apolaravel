@extends('templates.crud_template')

@section('crud_form')
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                {!!Html::image('css/images/torch-logo.png','APO Torch Logo',array('class'=>'img-responsive'))!!}
            </div>
            <div class="col-sm-8">
                <h1 class="ui inverted header">We can't find it!</h1>
                <p class="inverted">We are sorry - whatever you were looking for cannot be found.</p>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>
@endsection
