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
          allowTravelTime: function(){
              console.log('Computing if we can let the user fill in travel time.');
              return this.project_type === 'inside' && this.off_campus === '1';
          }
        },
        methods: {
            successFunction: function (data) {

            },
            setupUserSearch: function(){
                var users = new Resources.Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace,
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/users/search?query=%QUERY',
                        wildcard: '%QUERY'
                    }
                });
                $('.usersearch .typeahead').typeahead(null, {
                    name: 'users',
                    display: 'value',
                    source: users
                });
            }
        },
        filters: {
            isFalse: function (val) {
                return val === '0';
            }
        },
        ready: function(){
            this.setupUserSearch();
        }
    });
}

