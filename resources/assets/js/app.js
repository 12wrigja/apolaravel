/**
 * Created by James on 10/07/2015.
 */
//Setup jQuery and Bootstrap for the base UI
var $ = require('jquery');
window.$ = $;
window.jQuery = $;
require('bootstrap');
function getFromMetadata(tag){
    return $('meta[name="'+tag+'"]').attr('content');
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': getFromMetadata('csrf-token'),
        'Accept': 'application/json',
        'Content-Type' : 'application/json'
    }
});
require('Select2');
//Setup Vue and Vue Resource
var Vue = require('vue');
Vue.config.debug = true;
Vue.use(require('vue-resource'));
//Set default headers for all Vue requests
Vue.http.headers.common['X-CSRF-TOKEN'] = getFromMetadata('csrf-token');
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
        ServiceReport: function(instance) {
            return instance.$resource(getFromMetadata('service_report_api'),{},defaultActions);
        },
        BrotherhoodReport: function(instance) {
            return instance.$resource(getFromMetadata('brotherhood_report_api'),{},defaultActions);
        },
        User: function(instance){
            return instance.$resource(getFromMetadata('user_api'),{},defaultActions);
        },
        ChapterMeeting: function(instance){
            return instance.$resource(getFromMetadata('chapter_meeting_api'),{},defaultActions);
        },
        ExecMeeting: function(instance){
            return instance.$resource(getFromMetadata('exec_meeting_api'),{},defaultActions);
        },
        PledgeMeeting: function(instance){
            return instance.$resource(getFromMetadata('pledge_meeting_api'),{},defaultActions);
        },
        utils: {
            loadUnhide: function(rootElement){
                console.log(rootElement);
                console.log($(rootElement).find('.loadhidden'));
                $(rootElement).find('.loadhidden').removeClass('loadhidden').removeClass('hidden');
            },
        },
        select2settings: function(data,formatFn){
            return {
                data: data,
                allowClear: true,
                templateResult: formatFn,
                templateSelection: formatFn,
                multiple: 'multiple',
                matcher: function(params, brother){
                    // If there are no search terms, return all of the data
                    if ($.trim(params.term) === '') {
                        return brother;
                    }
                    if(brother.first_name.toLowerCase().indexOf(params.term.toLowerCase()) > -1){
                        return brother;
                    } else if (brother.last_name.toLowerCase().indexOf(params.term.toLowerCase()) > -1){
                        return brother;
                    } else if (brother.nickname != null && brother.nickname.toLowerCase().indexOf(params.term.toLowerCase()) > -1){
                        return brother;
                    } else if (brother.id.indexOf(params.term.toLowerCase()) > -1){
                        return brother;
                    } else {
                        return null;
                    }
                }
            }
        }
    }
}();
module.exports = Resources;
//Initialize a new Vue instance here
var main = new Vue({
    el: 'body',

    components: {
        'create_service_report_form' : require('./views/reports/servicereports/create.js')(Resources),
        'create_brotherhood_report_form' : require('./views/reports/brotherhoodreports/create.js')(Resources),
        'manage_service_reports_form' : require('./views/reports/servicereports/manage.js')(Resources),
        'manage_brotherhood_reports_form' : require('./views/reports/brotherhoodreports/manage.js')(Resources),
        'create_chapter_meeting_form' : require('./views/reports/chaptermeetings/create.js')(Resources),
        'create_pledge_meeting_form': require('./views/reports/pledgemeetings/create.js')(Resources),
        'create_exec_meeting_form' : require('./views/reports/execmeetings/create.js')(Resources),
        'form_editor' : require('./components/forms/editor.js')(Resources),
        'create_dues_report_form' : require('./views/reports/duesreports/create.js')(Resources)
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