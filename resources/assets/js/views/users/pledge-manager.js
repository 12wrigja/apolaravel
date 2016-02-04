module.exports = function (Resources) {
    return Resources.Vue.extend({
        data: function () {
            return {
                pledges: {},
                loading: false
            }
        },
        ready: function () {
            this.loadPledges();
            this.$on('pledge_created',function(){
                this.loadPledges();
            });
        },
        filters: {
            pnull: function ($value) {
                return ($value == null) ? 'Not Assigned' : $value;
            }
        },
        computed: {
            notLoading: function () {
                return !this.loading;
            },
            noPledges: function(){
                return !this.loading && this.pledges.data !== undefined && this.pledges.data.length == 0;
            }
        },
        methods: {
            loadPledges: function (ondone) {
                this.loading = true;
                Resources.User(this).get({
                    'contract': 'Pledge',
                    'initiation_semester': 'null',
                    'attrs': 'big,family'
                }, function (data, status, request) {
                    this.pledges = data;
                    this.loading = false;
                    if (ondone !== undefined) {
                        ondone();
                    }
                });
            },
            editPledge: function (pledge) {
                var editData = Resources.Vue.util.extend({}, pledge);
                if (editData.big !== null) {
                    editData.big = editData.big.id;
                } else {
                    delete editData.big;
                }
                if (editData.family !== null) {
                    editData.family_id = editData.family.id;
                } else {
                    editData.family_id = 1;
                }
                delete editData.family;
                delete editData.initiation_semester;
                this.$.editForm.form = editData;
                this.$.editForm.form.id = pledge.id;
                var instance = this;
                this.$on('successfulEdit', function (updatedReport) {
                    this.loadPledges(function () {
                        setTimeout(function () {
                            console.log('I should be expanding the previously edited pledge.');
                            $("#collapse" + updatedReport.id).collapse('show');
                        }, 500);
                    });
                });
                this.$.editForm.show();
            },
            initiatePledge: function(pledge){
                if(window.confirm("Are you sure you want to initiate this pledge? They will no longer be managable by the Pledge Educator, and will be removed from this list.")) {
                    Resources.User(this).put({id: pledge.id}, {initiation_semester: 'current'}, function (data, status, request) {
                        if (status == 200) {
                            this.loadPledges();
                        } else {
                            console.log('Error deleting pledge');
                            console.log(data);
                        }
                    });
                }
            },
            deletePledge: function(pledge){
                if(window.confirm("Are you sure you want to delete this pledge? They will no longer be able to sign in to thewebsite, and this is only reversible by the webmaster.")) {
                    Resources.User(this).delete({id: pledge.id}, function (data, status, request) {
                        if (status == 200) {
                            this.loadPledges();
                        } else {
                            console.log('Error deleting pledge');
                            console.log(data);
                        }
                    });
                }
            },
            getFormTemplate: function () {
                return {
                    first_name: '',
                    last_name: '',
                    id: '',
                    big: '',
                    family_id: ''
                }
            }
        }
    })
        ;
}
;
