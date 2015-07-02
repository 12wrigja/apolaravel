var Vue = require('vue');
Vue.use(require('vue-resource'));
var form = require('../../forms.js')(Vue);
var contract_create_form = form.extend({

    inherit: true,

    data: function () {
        return {
            form: {
                display_name: '',
                description: '',
                requirements: []
            }
        }
    }//,
    //
    //components: {
    //    'requirementpicker' : require('../../components/RequirementPicker/RequirementPicker.js'),
    //    'createrequirementmodal' : require('../../components/ContractRequirementCreateForm/ContractCreateModal.js')
    //}
});
Vue.component('contract-create-form',contract_create_form);
Vue.component('create-requirement-modal',form.extend(require('../../components/ContractRequirementCreateForm/ContractCreateModal.js')));
new Vue({
    el: 'body'
});

