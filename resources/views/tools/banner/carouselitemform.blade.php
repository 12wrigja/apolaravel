{!! Form::open(['route'=>['carousel_item_update','id'=>':id'],'class'=>'collapse in','v-el'=>'iform'])!!}

<div class="form-horizontal">
    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('title','Title') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            {!! Form::text('title', null, ['class'=>'form-control','v-model'=>'form.title']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('caption','Caption') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            {!! Form::text('caption', null, ['class'=>'form-control','v-model'=>'form.caption']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('action_text','Action Text') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            {!! Form::text('action_text', null, ['class'=>'form-control','v-model'=>'form.action_text']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">
            {!! Form::label('action_url','Action URL') !!}
            <p class="help-block"></p>
        </div>
        <div class="col-sm-10">
            {!! Form::text('action_url', null, ['class'=>'form-control','v-model'=>'form.action_url']) !!}
        </div>
    </div>
    <div class="form-group">
        <p></p>
        <file-dropzone route="{{route('upload_free_image')}}" file-types="images" input-name="image" max-files="1" message="Click here or drag an image here to use that as the background image. If you leave this blank the background image will remain the same."></file-dropzone>
    </div>
</div>

{!! Form::close() !!}


