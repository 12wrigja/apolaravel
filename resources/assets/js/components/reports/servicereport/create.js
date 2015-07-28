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
                },
                users : []
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
                Resources.User(this).get({},function(data,status,response){
                    if(status == 200){
                        this.users = data;
                        var that = this;
                        var selector = $('#brotherselecter');
                        selector.select2({
                            data: data,
                            allowClear: true,
                            templateResult: that.formatBrother,
                            templateSelection: that.formatBrother,
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
                        });
                        selector.on("select2:select", function(e){
                            //get the name of the thing selected.
                            that.addBrother(e);
                            e.params.data.disabled = true;
                            selector.val(null).trigger("change");
                        });
                    } else {
                        console.log("error: "+data);
                    }
                })
            },
            getForm: function () {
                var newForm = Resources.Vue.util.extend({}, this.form);
                newForm.off_campus = this.form === '1';
                var i = newForm.brothers.length;
                for(var j=0; j<i; j++){
                    newForm.brothers[j].is_driver = newForm.brothers[j].is_driver === '1';
                }
                return newForm;
            },
            formatBrother: function(brother){
                if(brother.nickname !== null){
                    return brother.nickname + ' ('+brother.first_name+') '+brother.last_name;
                } else {
                    return brother.first_name + ' ' +brother.last_name;
                }
            },
            addBrother: function(e){
                var broListing = e.params.data;
                console.log(this.formatBrother(broListing));
                var newBro = {
                    'id' : broListing.id,
                    'name' : this.formatBrother(broListing),
                    'hours' : 0,
                    'minutes' : 0,
                    'is_driver' : false
                };
                this.form.brothers.push(newBro);
            },
            removeBrother: function(brother){
                this.form.brothers.$remove(brother);

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

