var mainView = new Vue({

    el: "#crud_form_container",

    data: {
        create_form: {
            display_name: "",
            description: "",
            contract_events: []
        },
        contract_events: []
    },

    methods: {
        chooseExistingRequirement: function (requirement) {

        },
        removeRequirement: function (requirement) {

        },
        createRequirement: function (event) {
            event.preventDefault();
            var contractData = Vue.util.extend({}, this.requirement);
            contractData['contract_events'] = minimizeToIDs(this.requirement.contract_events);
            createRequirement(contractData);
        }
    },

    filters: {
        contractCreate: function (contract) {
            var formData = Vue.util.extend({}, contract);
            formData['requirements'] = minimizeToIDs(contract.requirements);
            return formData;
        }
    }
});

function createRequirement(requirementData) {
    var form = $('#create_contractreq_form');
    var url = form.attr('action');
    collapseSwap('#loadingArea','#create_contractreq_form');
    cleanupErrors('create_contract_form');
    $.post(url, requirementData, null).done(function (data) {
        window.location = $('meta[name="contractreq_index_url"]').attr('content');
    }).fail(function (error) {
        if (error.status >= 500) {
            console.log(error);
            document.open();
            document.write(error.responseText);
            document.close();
        } else {
            collapseSwap('#create_contractreq_form','#loadingArea');
            renderErrors('create_contractreq_form', error.responseJSON);
        }
    });
}

$(document).ready(function () {

});