module.exports = function (Vue) {
    return Vue.extend(
        {
            data: function () {
                return {
                    formID: '',
                    loadingID: 'loadingArea',
                    successURL: '',
                    method: 'POST',
                    debug: false
                }
            },

            computed: {
                formURL: function () {
                    return $('#' + this.formID).attr('action');
                }
            },

            methods: {
                submitForm: function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: this.formURL,
                        type: this.method,
                        data: this.form
                    }).done(function (data) {
                        window.location = this.successURL;
                    }).fail(function (error) {
                        if (error.status >= 500) {
                            //TODO update the error code management for production
                            console.log(error);
                            document.open();
                            document.write(error.responseText);
                            document.close();
                        } else {
                            console.log(error);
                            collapseSwap(this.formID, this.loadingID);
                            renderErrors(this.formID, error.responseJSON);
                        }
                    });
                },
                setupDebug: function () {
                    var that = this;
                    $(this.$el).append('<pre> test </pre>');
                    $(document).keydown(function (event) {
                        if (event.which == 192) {
                            if (event.shiftKey == true && event.ctrlKey == true) {
                                console.log('Changing Debug.');
                                event.preventDefault();
                                that.debug = !that.debug;
                                console.log(that.debug);
                            }
                        }
                    });
                }
            },

            ready: function () {
                this.setupDebug();
            }
        });
}
