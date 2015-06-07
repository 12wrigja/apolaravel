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
        },
        comparisons: {}
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
        prettyComparison: function (value) {
            return this.comparisons[value];
        },
        contractCreate: function (contract) {
            var formData = Vue.util.extend({}, contract);
            formData['requirements'] = minimizeToIDs(contract.requirements);
            return formData;
        }
    }
});

function setupComparisons() {
    $('#create_requirement_form select option').each(function () {
        mainView.$data.comparisons[$(this).val()] = $(this).text();
    });
}

function queryRequirements() {
    var xmlHttp = new XMLHttpRequest();
    var url = $('meta[name="requirement_url"]').attr('content');
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            //Do stuff with the response.
            var data = JSON.parse(xmlHttp.responseText);
            mainView.$data.requirements = data;
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

function createContract(contractData) {
    var form = $('#create_contract_form');
    var url = form.attr('action');
    collapseForm();
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
            expandForm();
            renderErrors('create_contract_form', error.responseJSON);
        }
    });
}

function collapseForm() {
    var form = $('#create_contract_form');
    var loading = $('#loadingArea');
    form.collapse('hide');
    loading.collapse('show');
}

function expandForm() {
    var form = $('#create_contract_form');
    var loading = $('#loadingArea');
    form.collapse('show');
    loading.collapse('hide');
}

function cleanupErrors(formID) {
    var formGroups = $('#' + formID + " .form-group.has-error");
    $.each(formGroups, function (index,group) {
        $(group).removeClass('has-error');
        $(group).children(".help-block").text('');
    });
}

function renderErrors(formID, jsonErrors) {
    $.each(jsonErrors, function (fieldName, error) {
        var field = $('#' + formID + ' [name="' + fieldName + '"]')[0];
        var parent = $(field).parent('.form-group')[0];
        $(parent).addClass('has-error');
        var errorBlock = $(parent).children(".help-block");
        $(errorBlock).text(error[0]);
    });
}

function minimizeToIDs(collection) {
    var result = [];
    for (var i = 0; i < collection.length; i++) {
        result.push(collection[i].id);
    }
    return result;
}

$(document).ready(function () {
    setupComparisons();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });
    queryRequirements();
});