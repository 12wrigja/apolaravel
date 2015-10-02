module.exports = function (Resources) {

    return Resources.Vue.extend({
        el: function () {
            return 'crud_form';
        },
        data: function () {
            return {
                reports: {},
                approved: {},
                reports_cache: {},
                approved_cache: {},
                reports_page: -1,
                approved_page: -1
            }
        },
        computed: {
            showReportPagination: function () {
                if(this.reports_page != -1 && this.reports != [] && this.reports.meta !== undefined) {
                    return this.reports.meta.pagination.total_pages > 0;
                } else {
                    return false;
                }
            },
            showApprovedPagination: function () {
                if(this.approved_page != -1 && this.approved != [] && this.approved.meta !== undefined) {
                    return this.approved.meta.pagination.total_pages > 0;
                } else {
                    return false;
                }
            }
        },
        methods: {
            approveReport: function (report) {
                Resources.ServiceReport(this).put({id: report.id}, {approved: true}, function (data, status, request) {
                    if (status == 200) {
                        this.reports.data.$remove(report);
                        if(this.approved_page == 1) {
                            this.approved.data.push(report);
                        }
                    } else {
                        console.log('Error approving report.');
                        console.log(data);
                        //var w  = window.open();
                        //$(w.document).html(data);
                    }
                });
            },
            deleteReport: function (report) {
                if(window.confirm("Are you sure you want to delete this report?")) {
                    Resources.ServiceReport(this).delete({id: report.id}, function (data, status, request) {
                        if (status == 200) {
                            console.log(this.reports);
                            this.reports.data.$remove(report);
                            this.approved.data.$remove(report);
                        } else {
                            console.log('Error approving report.');
                            console.log(data);
                        }
                    });
                }
            },
            getPage: function (page, approved) {
                //if (page <= 0) {
                //    return;
                //}
                //if (approved === 'true' && page in this.approved_cache) {
                //    return this.approved_cache[page];
                //} else if (approved === 'false' && page in this.reports_cache) {
                //    return this.reports_cache[page];
                //} else {
                    Resources.ServiceReport(this).get({}, {
                        'approved': approved,
                        'page': page
                    }, function (data, status, request) {
                        if (status == 200) {
                            if (approved) {
                                //this.approved_cache[page] = data;
                                this.approved_page = page;
                                this.approved = data;
                            } else {
                                //this.reports_cache[page] = data;
                                this.reports_page = page;
                                this.reports = data;
                            }
                        } else {
                            console.log(data);
                        }
                    });
                //}
            }
        },
        filters: {
            empty: function (array) {
                if (array && array !== null) {
                    return array.constructor === Array && array.length == 0;
                }
                return true;
            }
        },
        ready: function () {
            this.getPage(1, false);
            this.getPage(1, true);
        }
    });

};