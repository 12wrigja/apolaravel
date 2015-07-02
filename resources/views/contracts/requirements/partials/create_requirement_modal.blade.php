<create-requirement-modal inline-template>
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
                        Creating a Contract Requirement here will NOT link the requirement to any events that satisfy
                        it.
                        This can be accomplished using the Contract Requirement Manager.
                    </div>
                    @include('contracts.requirements.partials.create_requirement_form')
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-success" type="button" id="reqCreate" data-toggle="modal"
            data-target="#createRequirement">Create a new Requirement
    </button>
</create-requirement-modal>