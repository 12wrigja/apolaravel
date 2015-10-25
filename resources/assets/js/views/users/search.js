module.exports = function(Resources) {
    return Resources.Vue.extend({
       data: function(){
           return {
               users: [],
               isLoading: true,
               query: '',
           }
       },
        computed: {
            isNotLoading: function(){
                return !this.isLoading;
            },
            displayUsers: function(){
                var that = this;
                return this.users.filter(function(user){
                   return Resources.matchBrother(user,that.query) !== null;
                });
            }
        },
        created: function(){
            Resources.User(this).get({},function(data,status,response){
                this.isLoading = false;
                if(status == 200){
                    this.users = data['data'];
                } else {
                    console.log("error: "+data);
                    this.users = [];
                }
            });
        },
        ready: function(){
            this.$$.searchBox.addEventListener('submit',function(event){
                event.preventDefault();
            });
        }
    });
}
