module.exports = function (resources) {
    var contract_edit_form = resources.form.extend({

        data: function () {
            return {
                form: {
                    display_name: '',
                    description: '',
                    requirements: []
                },
                method: 'PUT'
            }
        },

        methods: {
            removeRequirement: function (requirement) {
                this.form.requirements.$remove(requirement);
                this.$broadcast('remove-requirement', requirement);
            },
            getForm: function () {
                var data = resources.Vue.util.extend({}, this.form);
                data.requirements = this.minimizeToIDs(data.requirements);
                return data;
            },
            successFunction: function (data) {
                console.log('Succeeded in creating contract!');
                window.location = $('meta[name=contract_index_url]').attr('content');
            },
        },

        ready: function () {
            this.$on('create-requirement', function (data) {
                this.form.requirements.push(data);
            });
            this.$on('pick-requirement', function (data) {
                this.form.requirements.push(data);
            });
            this.$on('get-requirements', function (requirements) {
                //Load the requirements that match into the table, leave the rest in the requirement picker.
                var contractRequirements = JSON.parse($('meta[name=contract_requirements]').attr('content'));
                var key1;
                for (key1 in contractRequirements) {
                    var id = contractRequirements[key1];
                    var key2;
                    for (key2 in requirements) {
                        var requirement = requirements[key2];
                        if (requirement.id == id) {
                            this.$emit('pick-requirement',requirement);
                            this.$broadcast('choose-requirement',requirement);
                        }
                    }
                }
            });
        },

        components: {
            'requirement-picker': require('../../components/RequirementPicker/requirementpicker.js')(resources),
            'create-requirement-form': require('../../components/ContractRequirementCreateForm/ContractCreateModal.js')(resources)
        }
    });
    return contract_edit_form;
}