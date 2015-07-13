module.exports = function (resources) {
    var contract_edit_form = resources.form.extend({

        data: function () {
            return {
                form: {
                    display_name: '',
                    description: '',
                    requirements: []
                },
                allRequirements: []
            }
        },

        methods: {
            removeRequirement: function (requirement) {
                this.form.requirements.$remove(requirement);
                this.$broadcast('remove-requirement', requirement);
            },
            getForm: function () {
                var data = Vue.util.extend({}, this.form);
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
            //this.$on('get-requirements', function (requirements) {
            //    console.log(requirements);
            //    //Load existing requirements into the table
            //    var ereqs = JSON.parse($('meta[name="contract_requirements"]').attr('content'));
            //    var that = this;
            //    var req;
            //    for (req in ereqs) {
            //        var key;
            //        for (key in requirements) {
            //            var requirement = requirements[key];
            //            console.log(requirement);
            //            console.log(requirement.id);
            //            if (requirement.id == req) {
            //                console.log('Found match.');
            //                that.$broadcast('remove-requirement', requirement);
            //                that.$emit('pick-requirement', requirement);
            //            }
            //        }
            //    }

                //$.each(ereqs,function(index,value){
                //    $.each(requirements, function(index, requirement){
                //       if(requirement.id == value){
                //           that.$broadcast('remove-requirement',requirement);
                //           that.$emit('pick-requirement',requirement);
                //       }
                //    });
                //});
            //});

        },

        components: {
            'requirement-picker': require('../../components/RequirementPicker/requirementpicker.js')(resources),
            'create-requirement-form': require('../../components/ContractRequirementCreateForm/ContractCreateModal.js')(resources)
        }
    });
    return contract_edit_form;
}