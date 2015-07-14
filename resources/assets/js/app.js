/**
 * Created by James on 10/07/2015.
 */
//Setup jQuery and Bootstrap for the base UI
var $ = require('jquery');
window.$ = $;
window.jQuery = $;
require('bootstrap');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json',
        'Content-Type' : 'application/json'
    }
});

//Setup Vue and Vue Resource
var Vue = require('vue');
Vue.use(require('vue-resource'));
//Set default headers for all Vue requests
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
var Resources = function () {

    var defaultActions = {
        get: {
            method: 'GET'
        },
        save: {
            method: 'POST'
        },
        update: {
            method: 'PUT'
        },
        delete: {
            method: 'DELETE'
        }
    }

    return {
        Vue: Vue,
        form: require('./components/forms/forms.js')(Vue),
        ContractRequirement: function (instance) {
            return instance.$resource('/contractreqs/:id');
        },
        Contract: function (instance) {
            return instance.$resource('/contracts/:id',{},defaultActions);
        },
        utils: {
            loadUnhide: function(rootElement){
                console.log(rootElement);
                console.log($(rootElement).find('.loadhidden'));
                $(rootElement).find('.loadhidden').removeClass('loadhidden').removeClass('hidden');
            }
        }
    }
}();
module.exports = Resources;
//Initialize a new Vue instance here
var main = new Vue({
    el: 'body',

    components: {
        'contract-create-form': require('./views/contracts/create.js')(Resources),
        'contract-edit-form': require('./views/contracts/edit.js')(Resources)
    },

    filters: {
        prettyComparison: function (value) {
            var comparisons = {
                'LT': 'Less Than',
                'LEQ': 'Less Than or Equal To',
                'EQ': 'Equal To',
                'GEQ': 'Greater Than or Equal To',
                'GT': 'Greater Than'
            };
            return function (val) {
                return comparisons[val];
            }(value);
        }
    },
});