/**
 * Created by james on 6/23/15.
 */
module.exports = function (resources) {

    var reqpicker = resources.Vue.extend({

            data: function () {
                return {
                    requirements: [],
                }
            }
            ,

            props: ['url'],

            methods: {
                getRequirements: function () {
                    resources.ContractRequirement(this).get({},function(data,status,request) {
                        if (status == 200) {
                            this.requirements = data;
                            this.$dispatch('get-requirements',data);
                        } else {
                            console.log('error: ' + status);
                        }
                    });
                },
                chooseRequirement: function(requirement){
                    this.requirements.$remove(requirement);
                    this.$dispatch('pick-requirement',requirement);
                }
            }
            ,

            ready: function () {
                console.log(this.url);
                this.getRequirements();
                console.log('RequirementPicker booted.');
                var that = this;
                this.$on('remove-requirement',function(requirement){
                    that.requirements.push(requirement);
                });
                this.$on('choose-requirement',function(requirement){
                    that.requirements.$remove(requirement);
                })
            }

        })
        ;
    //Vue.component('requirementpicker', reqpicker);
    return reqpicker;
}