/**
 * Created by james on 6/23/15.
 */
module.exports = function (resources) {

    var crm = resources.form.extend({

        data: function () {
            return {
                loadingText: 'Creating Contract Requirement...',
                form: {
                    display_name: '',
                    description: '',
                    comparison: '',
                    threshold: ''
                }
            }
        }
        ,

        methods: {
            successFunction: function(data){
                console.log('Created Contract Requirement.');
                this.$dispatch('create-requirement',data);
                this.$broadcast('create-requirement',data);
                var modal = $(this.$el).closest('modal');
                console.log(modal);
                if(modal[0]){
                    modal[0].modal('hide');
                }
            }
        },

    });
    //Vue.component('create-requirement-form', crm);
    return crm;
}