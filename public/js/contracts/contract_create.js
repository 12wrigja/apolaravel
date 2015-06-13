var mainView = new Vue({

    el: "#crud_form_container",

    data: {
        contract: {
            display_name: "",
            description: "",
            requirements: []
        },
        requirements: [],
        create_form: {
            id: "",
            display_name: "",
            description: "",
            threshold: "",
            comparison: "GEQ"
        }
    },

    methods: {
        chooseExistingRequirement: function (requirement) {
            this.contract.requirements.push(requirement);
            this.requirements.$remove(requirement);
        },
        removeRequirement: function (requirement) {
            this.contract.requirements.$remove(requirement);
            this.requirements.push(requirement);
        },
        createRequirement: function (event) {
            event.preventDefault();
            createNewRequirement(this.$data.create_form);
        },
        createContract: function (event) {
            event.preventDefault();
            var contractData = Vue.util.extend({}, this.contract);
            contractData['requirements'] = minimizeToIDs(this.contract.requirements);
            createContract(contractData);
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

function queryRequirements() {
    var url = $('meta[name="requirement_url"]').attr('content');
    $.ajax({
        url:url,
        type:'get'
    }).done(function(data){
        console.log(data);
        mainView.$data.requirements = data;
        $('tbody').removeClass('hidden');
    }).fail(function(error){
        console.log(error);
        if (error.status >= 500) {
            document.open();
            document.write(error.responseText);
            document.close();
        }
    });
}

function createNewRequirement(formData) {
    console.log('Creating a new contract requirement.');
    console.log(formData);
    var url = $('meta[name="requirement_create_url"]').attr('content');
    $.post(url, formData, null).done(function (data) {
        console.log(data);
        var form = mainView.$data.create_form;
        mainView.$data.contract.requirements.push(data);
        form.id = "";
        form.display_name = "";
        form.description = "";
        form.threshold = "";
        form.comparison = "GEQ";
        $('#createRequirement').modal('hide');
    })
        .fail(function (error) {
            console.log(error);
        });
}

function createContract(contractData) {
    var form = $('#create_contract_form');
    var url = form.attr('action');
    collapseSwap('#loadingArea','#create_contract_form');
    cleanupErrors('create_contract_form');
    $.post(url, contractData, null).done(function (data) {
        window.location = $('meta[name="contract_index_url"]').attr('content');
    }).fail(function (error) {
        if (error.status >= 500) {
            console.log(error);
            document.open();
            document.write(error.responseText);
            document.close();
        } else {
            collapseSwap('#create_contract_form','#loadingArea');
            renderErrors('create_contract_form', error.responseJSON);
        }
    });
}

$(document).ready(function () {
    queryRequirements();
});