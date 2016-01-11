module.exports = function(Resources){
    return Resources.Vue.extend({
       data: function(){
           return {
               pledges : [],

           }
       },
        ready: function(){
            Resources.User(this).get({'contract':'Pledge', 'attrs':'big,family'},function(data, status, request){
                this.pledges = data;
            });
        },
        filters: {
            pnull : function($value){
                return ($value == null)?'Not Assigned':$value;
            }

        },
        methods: {
            editPledge : function(pledge){
                var editData = Resources.Vue.util.extend({}, pledge);
                if(editData.big !== null){
                    editData.big = editData.big.id;
                }
                this.$.editForm.form = editData;
                this.$.editForm.form.id = pledge.id;
                var instance = this;
                this.$on('successfulEdit',function(updatedReport){
                    instance.pledges.data.forEach(function(item,index){
                        if(item.id === updatedReport.id){
                            instance.pledges.data.$set(index,updatedReport);
                            console.log('#collapse'+item.id);
                            var id = '#collapse'+item.id;
                            Resources.Vue.nextTick(function(){
                                $(id).collapse('show');
                            });
                        }
                    });
                });
                this.$.editForm.show();
            }
        }
    });
};
