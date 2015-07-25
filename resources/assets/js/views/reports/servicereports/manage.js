module.exports = function (Resources) {

    return Resources.Vue.extend({
        el: function () {
            return 'crud_form';
        },
        data: function () {
            return {
                reports: [],
                approved: []
            }
        },
        methods: {
            approveReport: function (report) {
                Resources.ServiceReport(this).approve({id: report.id}, {approved: true}, function (data, status, request) {
                    if (status == 200) {
                        this.reports.$remove(report);
                        this.approved.push(report);
                    } else {
                        console.log('Error approving report.');
                    }
                });
            },
            deleteReport: function (report) {
                Resources.ServiceReport(this).delete({id: report.id}, function (data, status, request) {
                    if (status == 200) {
                        this.reports.$remove(report);
                        this.approved.$remove(report);
                    } else {
                        console.log(data);
                    }
                });
            }
        },
        ready: function () {
            Resources.ServiceReport(this).listApproved({}, function (data, status, request) {
                if (status == 200) {
                    this.reports = data['data'];
                } else {
                    console.log(data);
                }
            });
            Resources.ServiceReport(this).listNotApproved({}, function (data, status, request) {
                if (status == 200) {
                    this.approved = data['data'];
                } else {
                    console.log(data);
                }
            });
        }
    });

};