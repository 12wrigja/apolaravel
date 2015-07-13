<create-requirement-form inline-template>

    {!! Form::open(['route'=>'contractreq_store','v-el'=>'iform']) !!}
    <div class="form-group">
        {!! Form::label('display_name','Display Name') !!}
        <p class="help-block"></p>
        {!! Form::text('display_name', null,
        ['class'=>'form-control','v-model'=>'form.display_name']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description','Description') !!}
        <p class="help-block"></p>
        {!! Form::textarea('description', null,
        ['class'=>'form-control','v-model'=>'form.description']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('comparison','Threshold Comparison:') !!}
        <p class="help-block"></p>
        {!! Form::select('comparison',[
        'LT'=>'Less Than',
        'LEQ'=>'Less Than or Equal To',
        'EQ'=>'Equal To',
        'GEQ'=>'Greater Than or Equal To',
        'GT'=>'Greater Than'], 'GEQ' ,['class'=>'form-control','v-model'=>'form.comparison']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('threshold','Threshold') !!}
        <p class="help-block"></p>
        {!! Form::text('threshold', null, ['class'=>'form-control','v-model'=>'form.threshold']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Create Contract Requirement', ['class'=>'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}
</create-requirement-form>