module.exports = function () {
    var contractreq_create_form = JSONForm.extend({

        inherit: true,

        data: function () {
            return {
                form: {
                    display_name: '',
                    description: '',
                    comparison: '',
                    threshold: ''
                }

            }
        }
    });
}

