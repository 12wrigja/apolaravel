/**
 * Created by James on 10/07/2015.
 */
//Setup jQuery and Bootstrap for the base UI
var $ = require('jquery');
window.$ = $;
window.jQuery = $;
require('bootstrap');

//Setup Vue and Vue Resource
var Vue = require('vue');
Vue.use(require('vue-resource'));
//Set default headers for all Vue requests
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
var Resources = {
    Vue: Vue,
    form: require('./components/forms/forms.js')(Vue),
    ContractRequirement: Vue.resource('/contractreqs/:id'),
    Contract: Vue.resource('/contracts/:id')
};
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
            return comparisons[value];
        }
    },
});