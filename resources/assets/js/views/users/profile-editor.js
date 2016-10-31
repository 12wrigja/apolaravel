module.exports = function(Resources){
    return Resources.form.extend({
        data: function(){
            return {
                method: 'PUT'
            }
        },
        props: ['user_id'],
        methods: {
            successFunction: function(data){
                $(this.$$.successArea).collapse('show');
                var that = this;
                setTimeout(function(){
                    window.location = Resources.getFromMetadata('user_api').replace(':id',that.user_id);
                },3000);
            }
        }
    });
};