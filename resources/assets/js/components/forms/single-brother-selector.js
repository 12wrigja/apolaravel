module.exports = function (Resources) {
    return Resources.Vue.extend({
        props: {
        },
        data: function () {
            return {
                storage: [],
                loading: true,
                brother: null
            }
        },
        computed: {
          notLoading: function(){
              return ! this.loading;
          }
        },
        template: require('./single-brother-selector.template.html'),
        methods: {
            setupUserSearch: function () {
                var that = this;
                this.loading = true;
                Resources.User(this).get({}, function (data, status, response) {
                    if (status == 200) {
                        var betterData = [];
                        data['data'].forEach(function(brother){
                           betterData[brother.id] = brother;
                        });
                        console.log(betterData);
                        that.storage = data['data'];
                        var selector = $(that.$$.selector);
                        selector.select2(Resources.select2singlesettings(that.storage, that.formatBrother));
                        selector.on("select2:select", function (e) {
                            console.log(e.params.data.id);
                            if(e.params.data !== undefined){
                                that.brother = e.params.data.id;
                            } else {
                                that.brother = null;
                            }

                        });
                        that.loading = false;
                    } else {
                        console.log("error: " + data);
                    }
                });
            },
            formatBrother: function (brother) {
                if (brother.nickname !== null && brother.nickname !== undefined) {
                    return brother.nickname + ' (' + brother.first_name + ') ' + brother.last_name;
                } else {
                    return brother.first_name + ' ' + brother.last_name;
                }
            }
        },
        ready: function () {
            this.loading = true;
            this.setupUserSearch();
            var that = this;
            this.$watch('brother',function(newVal, oldVal){
                console.log("Brother changed.");
                var select2 = $(that.$$.selector);
                select2.val(newVal).trigger("change");
            })
        }
    });
};
