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
require('Select2');
//Setup Vue and Vue Resource
var Vue = require('vue');
Vue.use(require('vue-resource'));
//Set default headers for all Vue requests
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
Vue.transition('collapse',{
   enter: function(el){
       $(el).addClass('in');
   },
    leave: function(el){
        $(el).removeClass('in');
    }
});
Vue.filter('not',function(value){
    return !value;
});
var Resources = function () {

    var defaultActions = {
        put: {
            method: 'PUT'
        }
   };

    return {
        Vue: Vue,
        form: require('./components/forms/forms.js')(Vue),
        ContractRequirement: function (instance) {
            return instance.$resource('/contractreqs/:id',{},defaultActions);
        },
        Contract: function (instance) {
            return instance.$resource('/contracts/:id',{},defaultActions);
        },
        ServiceReport: function(instance) {
            return instance.$resource('/reports/service_reports/:id',{},defaultActions);
        },
        User: function(instance){
            return instance.$resource('/users/:id',{},defaultActions);
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
        'contract-edit-form': require('./views/contracts/edit.js')(Resources),
        'create_service_report_form' : require('./components/reports/servicereport/create.js')(Resources),
        'manage-service-reports-view' : require('./views/reports/servicereports/manage.js')(Resources)
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