module.exports = function(Resources){
    return Resources.form.extend({
        data: function(){
            return {
                method: 'PUT'
            }
        },
        methods: {
            successFunction: function(data){
                $(this.$$.successArea).collapse('show');
                setTimeout(function(){
                    window.location = data.redirect;
                },3000);
            }
        }
    });
};