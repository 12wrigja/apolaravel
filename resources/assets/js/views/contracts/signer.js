module.exports = function (Resources) {
    return Resources.form.extend({
        data: function () {
            return {
                form: {
                    contract: "Active",
                    committees: [
                        {
                            name: "Membership",
                            tag: "membership",
                            rating: 1
                        },
                        {
                            name: "Service",
                            tag: "service",
                            rating: 2
                        },
                        {
                            name: "Fellowship",
                            tag: "fellowship",
                            rating: 3
                        },
                        {
                            name: "PR / Fundraising",
                            tag: 'pr',
                            rating: 4
                        },
                        {
                            name: "Historian / Alumni Secretary / Interchapter",
                            tag: 'history',
                            rating: 5
                        },
                        {
                            name: "Policy Book",
                            tag: "policy",
                            rating: 6
                        }
                    ]
                }
            }
        },
        methods: {
            successFunction: function(data){
              $(this.$$.successArea).collapse('show');
            },
            getForm: function(){
              return Resources.Vue.util.extend({},this.form);
            },
            increaseRating: function (c) {
                if(c.rating < 6){
                    var that = this;
                    for(var i=0; i<that.form.committees.length; i++){
                        if(that.form.committees[i].rating == c.rating + 1){
                            that.form.committees[i].rating --;
                            break;
                        }
                    }
                    c.rating ++;
                }
            },
            decreaseRating: function (c) {
                if(c.rating > 1){
                    var that = this;
                    for(var i=0; i<that.form.committees.length; i++){
                        if(that.form.committees[i].rating == c.rating - 1){
                            that.form.committees[i].rating ++;
                            break;
                        }
                    }
                    c.rating --;
                }
            },
            setContract: function(val){
                this.form.contract = val;
            }
        },
        ready: function(){
            console.log(this.form.committees);
        }
    });
};