var mainView = new Vue({

    el: "#crud_form_container",

    data: {
        create_form: {
            display_name: '',
            description: '',
            comparison: '',
            threshold: '',
            filters: []
        }
    },

    methods: {
        removeFilter: function (filter) {
            this.create_form.filters.$remove(filter);
        },
        createFilter: function () {
            var count = this.create_form.filters.length;
            console.log(count);
            this.create_form.filters.push({
                id: '',
                description: '',
                controller: '',
                method: '',
                execution_order: count + 1
            });
        },
        clearIfNotNumber: function(field){
            console.log($.isNumeric(field));
            if(!$.isNumeric(field)){
                console.log('reassigning');
                field = '';
            }
        },
        createRequirement: function (event) {
            event.preventDefault();
            var contractData = Vue.util.extend({}, this.create_form);
            createRequirement(contractData);
        }
    }
});

function createRequirement(requirementData) {
    var form = $('#create_contractreq_form');
    var url = form.attr('action');
    collapseSwap('#loadingArea', '#create_contractreq_form');
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
            collapseSwap('#create_contractreq_form', '#loadingArea');
            renderErrors('create_contractreq_form', error.responseJSON);
        }
    });
}