module.exports = function (Resources) {

    return Resources.Vue.extend({
        el: function () {
            return 'crud_form';
        },
        data: function () {
            return {
                reports: {},
                reports_page: -1
            }
        },
        computed: {
            showReportPagination: function () {
                if (this.reports_page != -1 && this.reports != [] && this.reports.meta !== undefined) {
                    return this.reports.meta.pagination.total_pages > 0;
                } else {
                    return false;
                }
            }
        },
        methods: {
            getPage: function (page, approved) {
                //if (page <= 0) {
                //    return;
                //}
                //if (approved === 'true' && page in this.approved_cache) {
                //    return this.approved_cache[page];
                //} else if (approved === 'false' && page in this.reports_cache) {
                //    return this.reports_cache[page];
                //} else {
                Resources.ChapterMeeting(this).get({}, {
                    'page': page,
                    'order': 'date'
                }, function (data, status, request) {
                    if (status == 200) {
                        //this.reports_cache[page] = data;
                        this.reports_page = page;
                        this.reports = data;
                    } else {
                        console.log(data);
                    }
                });
            },
            editReport: function (report) {
                this.$.editForm.form = Resources.Vue.util.extend({}, report);
                this.$.editForm.form.id = report.id;
                var instance = this;
                this.$on('successfulEdit', function (updatedReport) {
                    instance.reports.data.forEach(function (item, index) {
                        if (item.id === updatedReport.id) {
                            instance.reports.data.$set(index, updatedReport);
                            console.log('#collapse' + item.id);
                            var id = '#collapse' + item.id;
                            Resources.Vue.nextTick(function () {
                                $(id).collapse('show');
                            });
                        }
                    });
                });
                this.$.editForm.show();
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