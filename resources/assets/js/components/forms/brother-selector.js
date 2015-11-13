module.exports = function (Resources) {
    return Resources.Vue.extend({
        props: {
            brothers: {
                type: Array,
                required: true
            },
            attributes: {
                type: Array,
                required: true
            }
        },
        data: function () {
            return {
                storage: []
            }
        },
        template: require('./brother-selector.template.html'),
        methods: {
            setupUserSearch: function () {
                var that = this;
                var attrs = this.getParamsFromAttributes();
                Resources.User(this).get({'attrs': attrs}, function (data, status, response) {
                    if (status == 200) {
                        var betterData = [];
                        data['data'].forEach(function(brother){
                           betterData[brother.id] = brother;
                        });
                        console.log(betterData);
                        that.storage = data['data'];
                        var selector = $(that.$$.selector);
                        selector.select2(Resources.select2settings(that.storage, that.formatBrother));
                        selector.on("select2:select", function (e) {
                            //get the name of the thing selected.
                            if (!that.hasBrother(e)) {
                                that.addBrother(e);
                            }
                            selector.val(null).trigger("change");
                        });
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
            },
            addBrother: function (e) {
                var broListing = e.params.data;

                var newBro = {
                    id: broListing['id'],
                    first_name: broListing['first_name'],
                    last_name: broListing['last_name'],
                    display_name: broListing['display_name']
                };
                this.attributes.forEach(function (attribute) {
                    newBro[attribute.id] = broListing[attribute.id];
                });

                console.log("NewBro: " + JSON.stringify(newBro));
                this.brothers.push(newBro);
            },
            removeBrother: function (brother) {
                this.brothers.$remove(brother);

            },
            hasBrother: function (e) {
                var broListing = e.params.data;
                var length = this.brothers.length;
                for (var i = 0; i < length; i++) {
                    if (this.brothers[i].id === broListing.id) {
                        return true;
                    }
                }
                return false;
            },
            getParamsFromAttributes: function () {
                var string = "";
                var includedAttributes = [];
                this.attributes.forEach(function (attr) {
                    if (attr.default === undefined) {
                        includedAttributes.push(attr.id);
                    }
                });
                string = includedAttributes.join(',');
                return string;
            },
        },
        ready: function () {
            this.setupUserSearch();
        }
    });
};
