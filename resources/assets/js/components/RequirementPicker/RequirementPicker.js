/**
 * Created by james on 6/23/15.
 */
module.exports = {

    data : function(){
        return {
            requirements: [],
            comparisons: {
            'LT': 'Less Than',
            'LEQ': 'Less Than or Equal To',
            'EQ': 'Equal To',
            'GEQ': 'Greater Than or Equal To',
            'GT': 'Greater Than'
           }
        }
    },

    props: ['url'],

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

    filters: {
        'prettyComparison' : function(value){
            return this.comparisons[value];
        }
    },

    ready: function(){
        console.log(this.url);
        this.getRequirements();
        console.log('RequirementPicker booted.');
    }

};