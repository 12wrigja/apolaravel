<requirementpicker inline-template>
    <div class="modal fade" id="existingRequirements" tabindex="-1" role="dialog" aria-labelledby="largeModal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Choose an existing requirement</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover" id="existingRequirementsTable">
                        <thead>
                        <th>
                            Requirement Name
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Success Comparison Type
                        </th>
                        <th>
                            Threshold
                        </th>

                        <th>

                        </th>
                        </thead>

                        <tr v-repeat="requirement: requirements | orderBy 'display_name'">
                            <td>
                                @{{ requirement.display_name }}
                            </td>
                            <td>
                                @{{ requirement.description }}
                            </td>
                            <td>
                                @{{ requirement.comparison | prettyComparison }}
                            </td>
                            <td>
                                @{{ requirement.threshold }}
                            </td>
                            <td>
                                <button class="btn btn-primary" type="button" data-dismiss="modal"
                                        v-on="click: chooseExistingRequirement(requirement)">Choose
                                </button>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="button" data-toggle="modal"
            data-target="#existingRequirements">Link an Existing Requirement
    </button>
</requirementpicker>