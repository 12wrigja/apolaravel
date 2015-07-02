/**
 * Created by james on 6/23/15.
 */
module.exports = {

    data : function(){
        return {
            requirements: []
        }
    },

    methods: {
        getRequirements: function () {
            this.$http.get(this.url,null, function(data, status, request){
                if(status == 200){
                    this.requirements = data;
                } else {
                    console.log('error: '+status);
                }
            });
        }
    },

    computed : {
        url: function(){
            return $('.REQUIREMENT_PICKER').attr('url');
        }
    },

    ready: function(){
        this.getRequirements();
        console.log('RequirementPicker booted.');
    }

};