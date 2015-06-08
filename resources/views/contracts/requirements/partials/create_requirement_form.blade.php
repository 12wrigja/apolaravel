{!! Form::open(['route'=>'contractreq_store','v-on'=>'submit: createRequirement($event)','id'=>'create_requirement_form']) !!}
<div class="form-group">
    {!! Form::label('display_name','Display Name') !!}
    {!! Form::text('display_name', null,
    ['class'=>'form-control','v-model'=>'create_form.display_name']) !!}
</div>

<div class="form-group">
    {!! Form::label('description','Description') !!}
    {!! Form::textarea('description', null,
    ['class'=>'form-control','v-model'=>'create_form.description']) !!}
</div>

<div class="form-group">
    {!! Form::label('comparison','Threshold Comparison:') !!}
    {!! Form::select('comparison',[
    'LT'=>'Less Than',
    'LEQ'=>'Less Than or Equal To',
    'EQ'=>'Equal To',
    'GEQ'=>'Greater Than or Equal To',
    'GT'=>'Greater Than'], 'GEQ' ,['class'=>'form-control','v-model'=>'create_form.comparison']) !!}
</div>

<div class="form-group">
    {!! Form::label('Threshold','Threshold') !!}
    {!! Form::text('Threshold', null, ['class'=>'form-control','v-model'=>'create_form.threshold
    ','number']) !!}
</div>


<div class="form-group">
    {!! Form::submit('Create Contract Requirement', ['class'=>'btn btn-primary form-control']) !!}
</div>

{!! Form::close() !!}