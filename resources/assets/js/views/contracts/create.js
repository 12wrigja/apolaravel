module.exports = function (resources) {
    var contract_create_form = resources.form.extend({

        data: function () {
            return {
                form: {
                    display_name: '',
                    description: '',
                    requirements: []
                },
                loaded: false
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
            }
        },

        ready: function () {
            this.$on('create-requirement', function (data) {
                this.form.requirements.push(data);
            });
            this.$on('pick-requirement', function (data) {
                this.form.requirements.push(data);
            });
        },

        components: {
            'requirement-picker': require('../../components/RequirementPicker/requirementpicker.js')(resources),
            'create-requirement-form': require('../../components/ContractRequirementCreateForm/ContractCreateModal.js')(resources)
        }
    });
    return contract_create_form;
}