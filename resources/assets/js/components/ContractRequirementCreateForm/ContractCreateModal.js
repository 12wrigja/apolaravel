/**
 * Created by james on 6/23/15.
 */
module.exports = {

    data : function(){
        return {
            form: {
                display_name: '',
                description: '',
                comparison: '',
                threshold: ''
            }
        }
    },

    methods: {

    },

    computed : {
        url: function(){
            return $('.REQUIREMENT_PICKER').attr('url');
        }
    },

    ready: function(){
        console.log('Contract Create Modal Booted');
    }

};