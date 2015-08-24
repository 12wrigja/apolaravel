module.exports = function (Resources) {

    return Resources.form.extend({

        data: function () {
            return {
                form: {
                    brothers: [],
                    display_name: '',
                    description: '',
                    event_date: '',
                    type: ''
                },
                users : []
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

