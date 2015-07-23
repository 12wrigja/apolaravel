module.exports = function (Resource) {

    return Resource.Vue.extend({
        el: function () {
            return 'crud_form';
        },
        data: function () {
            return {
                reports: [],
                approved: []
            }
        },
        functions: {
            approveReport: function(report){
                Resource.ServiceReport(this).approve(report.id,function(data,status,request){
                   if(status == 200){
                       this.reports.$remove(report);
                       this.approved.push(report);
                   } else {
                        console.log('Error approving report.');
                   }
                });
            }
        },
        ready: function(){
            Resource.ServiceReport(this).listApproved({},function(data,status,request){
                if(status == 200) {
                    this.reports = data['data'];
                } else {
                    console.log(data);
                }
            });
            Resource.ServiceReport(this).listNotApproved({},function(data,status,request){
                if(status == 200) {
                    this.approved = data['data'];
                } else {
                    console.log(data);
                }
            });
        }
    });

};