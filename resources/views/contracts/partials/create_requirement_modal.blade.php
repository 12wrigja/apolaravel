<div class="modal fade" id="createRequirement" tabindex="-1" role="dialog" aria-labelledby="largeModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Create a contract requirement</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-warning alert-important" role="alert">
                    Creating a Contract Requirement here will NOT link the requirement to any events that satisfy it.
                    This can be accomplished using the Contract Requirement Manager.
                </div>

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
            </div>
        </div>
    </div>
</div>