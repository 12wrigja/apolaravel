module.exports = function (Vue) {
    var form = Vue.extend(
        {
            data: function () {
                return {
                    loadingText: '',
                    method: 'POST',
                    debug: true
                }
            },

            computed: {
                formURL: function () {
                    return $(this.$$.iform).attr('action');
                },
            },

            methods: {
                register: function () {
                    console.log('Registering form.');
                    console.log(this.formURL);
                    this.$$.iform.addEventListener('submit', this.submitForm);
                },
                submitForm: function (event) {
                    console.log('Submitting form.');
                    console.log(this.formURL);
                    event.preventDefault();
                    this.setLoading();
                    this.cleanupErrors();
                    var instance = this;
                    $.ajax({
                        url: this.formURL,
                        type: this.method,
                        data: JSON.stringify(this.getForm())
                    }).done(function (data) {
                        console.log("Successful call to " + this.formURL);
                        instance.successFunction(data);
                    }).fail(function (error) {
                        if (error.status >= 500) {
                            //TODO update the error code management for production
                            console.log(error);
                            document.open();
                            document.write(error.responseText);
                            document.close();
                        } else {
                            console.log(error);
                            instance.renderErrors(error.responseJSON);
                            instance.setNotLoading();
                        }
                    });
                },
                getForm: function(){
                  return this.form;
                },
                setupLoading: function () {
                    $(this.$el).after('<div class="alert alert-info alert-important collapse loading" role="alert">' +
                        '<h3 class="text-center">Creating Contract...</h3>' +
                        '<div class="progress">' +
                        '<div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>' +
                        '</div>' +
                        '</div>');
                },
                setupDebug: function () {
                    $(this.$el).after('<pre v-show="debug"> {{ getForm() | json }} </pre>');
                },
                setLoading: function () {
                    $(this.$$.loadingArea).collapse('show');
                    $(this.$el).collapse('hide');
                },
                setNotLoading: function () {
                    $(this.$el).collapse('show');
                    $(this.$$.loadingArea).collapse('hide');
                },
                collapseSwap: function (obj1, obj2) {
                    $(obj1).collapse('show');
                    $(obj2).collapse('hide');
                },
                renderErrors: function (jsonErrors) {
                    var instance = this;
                    $.each(jsonErrors, function (fieldName, error) {
                        var field = $(instance.$el).find('[name="' + fieldName + '"]')[0];
                        var parent = $(field).parent('.form-group')[0];
                        $(parent).addClass('has-error');
                        var errorBlock = $(parent).children(".help-block");
                        $(errorBlock).text(error[0]);
                    });
                },
                cleanupErrors: function () {
                    var formGroups = $(this.$el).find(".form-group.has-error");
                    $.each(formGroups, function (index, group) {
                        $(group).removeClass('has-error');
                        $(group).children(".help-block").text('');
                    });
                },
                successFunction: function (data) {
                    console.log('Default Success Function Called.');
                },
                minimizeToIDs: function (collection) {
                    var result = [];
                    if ($.isArray(collection)) {
                        for (var i = 0; i < collection.length; i++) {
                            result.push(collection[i].id);
                        }
                    }
                    return result;
                }
            },
            beforeCompile: function () {
                this.setupDebug();
                this.setupLoading();
            },
            ready: function () {
                this.register();
            }
        });
    return form;
}
