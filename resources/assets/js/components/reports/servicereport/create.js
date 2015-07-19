module.exports = function (Resources) {
    return Resources.form.extend({

        data: function () {
            return {
                form: {
                    display_name: '',
                    description: '',
                    event_date: '',
                    location: '',
                    off_campus: '',
                    travel_time: ''
                }

            }
        },
        filters: {
            'isFalse' : function(val){
                console.log(val)
                return val === '0';
            }
        }
    });
}

