module.exports = function (Resources) {

    return Resources.form.extend({

        data: function () {
            return {
                form: {
                    brothers: [],
                    display_name: '',
                    description: '',
                    event_date: '',
                    location: '',
                    off_campus: '',
                    project_type: '',
                    service_type: '',
                    travel_time: '',
                }

            }
        },
        computed: {
            allowTravelTime: function () {
                console.log('Computing if we can let the user fill in travel time.');
                return this.form.project_type === 'inside' && this.form.off_campus === '1';
            },
            allowOffCampus: function () {
                return this.form.project_type === "inside";
            }
        },
        methods: {
            successFunction: function (data) {

            },
            setupUserSearch: function () {
                //var users = new Resources.Bloodhound({
                //    datumTokenizer: Bloodhound.tokenizers.whitespace,
                //    queryTokenizer: Bloodhound.tokenizers.whitespace,
                //    remote: {
                //        url: '/users/search?query=%QUERY',
                //        wildcard: '%QUERY'
                //    }
                //});
                //$('.usersearch .typeahead').typeahead(null, {
                //    name: 'users',
                //    display: 'value',
                //    source: users
                //});
            },
            getForm: function () {
                var newForm = Resources.Vue.util.extend({}, this.form);
                newForm.off_campus = this.form === '1';
                return newForm;
            }
        },
        filters: {
            isFalse: function (val) {
                return val === '0';
            }
        },
        ready: function () {
            this.setupUserSearch();
        }
    });
}

