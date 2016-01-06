module.exports = function(Resources){
    return Resources.Vue.extend({
       data: function(){
           return {
               pledges : [],

           }
       },
        ready: function(){
            Resources.User(this).get({'status':'Pledge'},function(data, status, request){
                console.log(data);
            });
        }
    });
};
