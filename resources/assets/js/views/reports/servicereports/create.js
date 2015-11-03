module.exports = function (Resources) {

    return Resources.form.extend({

        data: function () {
            return {
                form: {
                    brothers: [],
                    event_name: '',
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
                $(this.$$.loadingArea).collapse('hide');
                $(this.$$.successArea).collapse({'toggle':false});
                $(this.$$.successArea).collapse('show');
            },
            setupUserSearch: function () {
                var that = this;
                Resources.User(this).get({},function(data,status,response){
                    if(status == 200){
                        that.users = data['data'];
                        var selector = $('#brotherselecter');
                        selector.select2(Resources.select2settings(data['data'],that.formatBrother));
                        selector.on("select2:select", function(e){
                            //get the name of the thing selected.
                            if(!that.hasBrother(e)){
                                that.addBrother(e);
                            }
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
                if(brother.nickname !== null && brother.nickname !== undefined){
                    return brother.nickname + ' ('+brother.first_name+') '+brother.last_name;
                } else {
                    return brother.first_name + ' ' +brother.last_name;
                }
            },
            addBrother: function(e){
                var broListing = e.params.data;
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

            },
            hasBrother: function(e){
                var broListing = e.params.data;
                var length = this.form.brothers.length;
                for(var i=0; i<length; i++){
                    if(this.form.brothers[i].id == broListing.id){
                        return true;
                    }
                }
                return false;
            },
            clearForm: function(){
                this.form = {
                    brothers: [],
                    event_name: '',
                    description: '',
                    event_date: '',
                    location: '',
                    off_campus: '',
                    project_type: '',
                    service_type: '',
                    travel_time: '',
                };
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

