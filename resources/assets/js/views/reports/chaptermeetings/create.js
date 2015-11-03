module.exports = function (Resources) {

    return Resources.form.extend({

        data: function () {
            return {
                form: {
                    brothers: [],
                    display_name: '',
                    description: '',
                    event_date: ''
                },
                users : []
            }
        },
        methods: {
            successFunction: function (data) {
                $(this.$$.successArea).collapse('show');
            },
            setupUserSearch: function () {
                Resources.User(this).get({},function(data,status,response){
                    if(status == 200){
                        this.users = data['data'];
                        var that = this;
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
                newForm.display_name = "Chapter Meeting " + newForm.event_date;
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
                    'name' : this.formatBrother(broListing)
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
                    display_name: '',
                    description: '',
                    event_date: ''
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
};
