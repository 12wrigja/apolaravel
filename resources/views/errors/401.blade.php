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
					<h1 class="ui inverted header">Authorization Error!</h1>
                    <p class="inverted">
                        @if(Session::has('login_error'))
                            {{ Session::get('login_error') }}
                        @else
                            We're sorry - you need to be a member of APO Theta Upsilon to
                            view this page.
                        @endif
                    </p>
					<p>If you feel this is in error, please email the webmaster for help at
						{!!Html::mailTo('webmaster@apo.case.edu')!!}.</p>
				</div>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>
@endsection
