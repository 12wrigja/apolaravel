module.exports = function (Resources) {
    return Resources.form.extend({
        data: function () {
            return {
                brothers: [],
                brotherAttributes: [
                    {
                        id: 'contract',
                        header: 'Contract Signed',
                        binding: 'contract',
                        display: {
                            type: 'select',
                            options: [
                                {
                                    text: "Active",
                                    value: "Active"
                                },
                                {
                                    text: "Associate",
                                    value: "Associate"
                                },
                                {
                                    text: "Pledge",
                                    value: "Pledge"
                                },
                                {
                                    text: "Member in Absentia",
                                    value: "MemberInAbsentia"
                                },
                                {
                                    text: "Alumni",
                                    value: "Alumni"
                                },
                                {
                                    text: "Adviser",
                                    value: "Adviser"
                                },
                                {
                                    text: "Inactive",
                                    value: "Inactive"
                                }
                            ]
                        }
                    }
                ]
            }
        },
        methods: {
            getForm: function () {
                var newForm = {};
                newForm.brothers = JSON.parse(JSON.stringify(this.brothers))
                return newForm;
            },
            successFunction: function (data) {
                //Update the relevant brothers in the array to show their new statuses
                this.$.broselector.setupUserSearch();
                $(this.$$.loadingArea).collapse('hide');
                $(this.$$.successArea).collapse({'toggle': false});
                $(this.$$.successArea).collapse('show');
            },
            clearForm: function(){
                this.brothers = [];
            },
        },
    });
};