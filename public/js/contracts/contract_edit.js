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
            comparison: "GEQ",
            _token: ""
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
        updateContract: function (event) {
            event.preventDefault();
            var contractData = Vue.util.extend({}, this.contract);
            contractData['requirements'] = minimizeToIDs(this.contract.requirements);
            updateContract(contractData);
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
    var xmlHttp = new XMLHttpRequest();
    var url = $('meta[name="requirement_url"]').attr('content');
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            //Do stuff with the response.
            var data = JSON.parse(xmlHttp.responseText);
            mainView.$data.requirements = data;

            //Compare requirements and place them appropriately.
            var string = $('meta[name="contract_requirements"]').attr('contents')
            var contract_reqs = $.parseJSON(string);
            $.each(contract_reqs,function(index,value){
                $.each(mainView.$data.requirements,function(index,requirement){
                   if(requirement.id == value){
                       mainView.$data.requirements.$remove(requirement);
                       mainView.$data.contract.requirements.push(requirement);
                       return false;
                   }
                });
            });
            $('tbody').removeClass('hidden');
        }
    };
    xmlHttp.open('GET', url, true);
    xmlHttp.send();
}

function createNewRequirement(formData) {
    console.log('Creating a new contract requirement.');
    console.log(formData);
    var xmlHttp = new XMLHttpRequest();
    var url = '/contractreqs';
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

function updateContract(contractData) {
    var form = $('#edit_contract_form');
    var url = form.attr('action');
    collapseSwap('#loadingArea','#edit_contract_form');
    cleanupErrors('edit_contract_form');
    $.ajax({
        url:url,
        data: contractData,
        type: 'PUT'
    }).done(function (data) {
        window.location = $('meta[name="contract_index_url"]').attr('content');
    }).fail(function (error) {
        if (error.status >= 500) {
            console.log(error);
            document.open();
            document.write(error.responseText);
            document.close();
        } else {
            renderErrors('edit_contract_form', error.responseJSON);
            collapseSwap('#edit_contract_form','#loadingArea');
        }
    });
}

$(document).ready(function(){
    queryRequirements();
});