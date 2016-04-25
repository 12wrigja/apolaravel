<p>Please explain why you are going inactive this semester, or what could have been
    done
    better
    by
    the chapter. </p>

<div class="form-group">
    <div class="col-sm-2 control-label">
        {!! Form::label('reason','Reason') !!}
        <p class="help-block"></p>
    </div>
    <div class="col-sm-10">
        {!! Form::textarea('reason', null, ['class'=>'form-control','v-model'=>'form.reason']) !!}
    </div>
</div>