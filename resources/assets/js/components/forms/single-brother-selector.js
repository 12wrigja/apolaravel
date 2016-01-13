module.exports = function (Resources) {
    return Resources.Vue.extend({
        props: {
            brother: {
                required: true,
                type: String
            }
        },
        data: function () {
            return {
                storage: [],
                loading: true,
                selector: {}
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
                            brother.text = that.formatBrother(brother);
                           betterData[brother.id] = brother;
                        });
                        that.storage = data['data'];
                        that.selector = $(that.$$.selector).select2(Resources.select2singlesettings(that.storage, that.formatBrother));
                        that.selector.on("select2:select", function (e) {
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
            this.$watch('brother',function(newVal, oldVal){
               this.selector.val(newVal).trigger('change');
            });
        }
    });
};
